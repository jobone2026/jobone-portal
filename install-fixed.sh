#!/bin/bash

###############################################################################
# JobOne.in - One-Click Installation Script (FIXED VERSION)
# This script automates the complete deployment on Ubuntu 22.04/24.04 LTS
# All known issues from previous deployments have been fixed
###############################################################################

set -e  # Exit on any error

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Configuration
APP_NAME="jobone"
APP_DIR="/var/www/$APP_NAME"
GITHUB_REPO="https://github.com/jobone2026/jobone-portal.git"
PHP_VERSION="8.2"
NODE_VERSION="20"

###############################################################################
# Helper Functions
###############################################################################

print_header() {
    echo -e "\n${BLUE}═══════════════════════════════════════════════════════════════${NC}"
    echo -e "${BLUE}  $1${NC}"
    echo -e "${BLUE}═══════════════════════════════════════════════════════════════${NC}\n"
}

print_success() {
    echo -e "${GREEN}✓ $1${NC}"
}

print_error() {
    echo -e "${RED}✗ $1${NC}"
}

print_warning() {
    echo -e "${YELLOW}⚠ $1${NC}"
}

print_info() {
    echo -e "${BLUE}ℹ $1${NC}"
}

check_root() {
    if [[ $EUID -eq 0 ]]; then
        print_error "This script should NOT be run as root"
        print_info "Run as ubuntu user: bash install-fixed.sh"
        exit 1
    fi
}

prompt_input() {
    local prompt="$1"
    local var_name="$2"
    local default="$3"
    
    if [ -n "$default" ]; then
        read -p "$(echo -e ${YELLOW}$prompt [${default}]: ${NC})" input
        eval $var_name="${input:-$default}"
    else
        read -p "$(echo -e ${YELLOW}$prompt: ${NC})" input
        eval $var_name="$input"
    fi
}

prompt_password() {
    local prompt="$1"
    local var_name="$2"
    
    read -sp "$(echo -e ${YELLOW}$prompt: ${NC})" password
    echo
    eval $var_name="$password"
}

###############################################################################
# Main Installation Functions
###############################################################################

collect_configuration() {
    print_header "Configuration Setup"
    
    print_info "Please provide the following information:"
    echo
    
    # Get server IP automatically
    SERVER_IP=$(curl -s ifconfig.me || hostname -I | awk '{print $1}')
    print_info "Detected server IP: $SERVER_IP"
    
    prompt_input "Domain name (or press Enter to use IP)" DOMAIN_NAME "$SERVER_IP"
    
    # Database configuration - use fixed values to avoid syntax errors
    DB_NAME="govt_job_portal"
    DB_USER="jobone"
    print_info "Database name: ${DB_NAME}"
    print_info "Database user: ${DB_USER}"
    
    # Auto-generate secure database password
    DB_PASSWORD=$(openssl rand -base64 32 | tr -d "=+/" | cut -c1-25)
    print_info "Database password auto-generated (will be saved in .env)"
    
    prompt_input "Admin email" ADMIN_EMAIL "admin@jobone.in"
    
    # Admin password with validation
    while true; do
        prompt_password "Admin password (min 8 characters)" ADMIN_PASSWORD
        if [ ${#ADMIN_PASSWORD} -ge 8 ]; then
            break
        else
            print_error "Password must be at least 8 characters"
        fi
    done
    
    prompt_input "Your email (for SSL certificate)" SSL_EMAIL "jobone2026@gmail.com"
    
    # Ask about SSL
    if [[ "$DOMAIN_NAME" =~ ^[0-9]+\.[0-9]+\.[0-9]+\.[0-9]+$ ]]; then
        INSTALL_SSL="no"
        print_warning "Using IP address - SSL will be skipped"
    else
        read -p "$(echo -e ${YELLOW}Install SSL certificate? [y/N]: ${NC})" -n 1 -r
        echo
        if [[ $REPLY =~ ^[Yy]$ ]]; then
            INSTALL_SSL="yes"
        else
            INSTALL_SSL="no"
        fi
    fi
    
    echo
    print_success "Configuration collected"
}

update_system() {
    print_header "Updating System"
    
    export DEBIAN_FRONTEND=noninteractive
    sudo -E apt update
    sudo -E apt upgrade -y -o Dpkg::Options::="--force-confdef" -o Dpkg::Options::="--force-confold"
    
    print_success "System updated"
}

install_nginx() {
    print_header "Installing Nginx"
    
    sudo apt install nginx -y
    sudo systemctl start nginx
    sudo systemctl enable nginx
    
    print_success "Nginx installed and started"
}

install_php() {
    print_header "Installing PHP $PHP_VERSION"
    
    sudo apt install software-properties-common -y
    sudo add-apt-repository ppa:ondrej/php -y
    sudo apt update
    
    sudo apt install -y \
        php${PHP_VERSION}-fpm \
        php${PHP_VERSION}-cli \
        php${PHP_VERSION}-common \
        php${PHP_VERSION}-mysql \
        php${PHP_VERSION}-zip \
        php${PHP_VERSION}-gd \
        php${PHP_VERSION}-mbstring \
        php${PHP_VERSION}-curl \
        php${PHP_VERSION}-xml \
        php${PHP_VERSION}-bcmath \
        php${PHP_VERSION}-intl \
        php${PHP_VERSION}-sqlite3
    
    # Configure PHP-FPM
    sudo sed -i 's/;cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/' /etc/php/${PHP_VERSION}/fpm/php.ini
    sudo systemctl restart php${PHP_VERSION}-fpm
    
    print_success "PHP $PHP_VERSION installed and configured"
}

install_mysql() {
    print_header "Installing MySQL"
    
    export DEBIAN_FRONTEND=noninteractive
    sudo -E apt install mysql-server -y
    sudo systemctl start mysql
    sudo systemctl enable mysql
    
    # Fix MySQL strict mode for TEXT columns with default values
    sudo tee -a /etc/mysql/mysql.conf.d/mysqld.cnf > /dev/null <<EOF

# Custom configuration for Laravel
[mysqld]
sql_mode=NO_ENGINE_SUBSTITUTION
EOF
    
    sudo systemctl restart mysql
    
    print_success "MySQL installed and started"
}

configure_mysql() {
    print_header "Configuring MySQL Database"
    
    # Create database and user using sudo mysql (works on fresh Ubuntu installations)
    sudo mysql <<MYSQL_SCRIPT
CREATE DATABASE IF NOT EXISTS ${DB_NAME} CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER IF NOT EXISTS '${DB_USER}'@'localhost' IDENTIFIED BY '${DB_PASSWORD}';
GRANT ALL PRIVILEGES ON ${DB_NAME}.* TO '${DB_USER}'@'localhost';
FLUSH PRIVILEGES;
MYSQL_SCRIPT
    
    print_success "MySQL database configured"
    print_info "Database: ${DB_NAME}"
    print_info "Username: ${DB_USER}"
}

install_composer() {
    print_header "Installing Composer"
    
    if ! command -v composer &> /dev/null; then
        cd /tmp
        curl -sS https://getcomposer.org/installer -o composer-setup.php
        sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer
        rm composer-setup.php
        print_success "Composer installed"
    else
        print_info "Composer already installed"
    fi
}

install_nodejs() {
    print_header "Installing Node.js $NODE_VERSION"
    
    if ! command -v node &> /dev/null; then
        curl -fsSL https://deb.nodesource.com/setup_${NODE_VERSION}.x | sudo -E bash -
        sudo apt install nodejs -y
        print_success "Node.js installed"
    else
        print_info "Node.js already installed"
    fi
}

install_supervisor() {
    print_header "Installing Supervisor"
    
    sudo apt install supervisor -y
    sudo systemctl enable supervisor
    sudo systemctl start supervisor
    
    print_success "Supervisor installed"
}

clone_repository() {
    print_header "Cloning Application Repository"
    
    if [ -d "$APP_DIR" ]; then
        print_warning "Directory $APP_DIR already exists. Removing..."
        sudo rm -rf $APP_DIR
    fi
    
    sudo mkdir -p /var/www
    cd /var/www
    sudo git clone $GITHUB_REPO $APP_NAME
    sudo chown -R $USER:www-data $APP_DIR
    
    print_success "Repository cloned"
}

install_dependencies() {
    print_header "Installing Application Dependencies"
    
    cd $APP_DIR
    
    print_info "Installing PHP dependencies..."
    composer install --optimize-autoloader --no-dev --no-interaction
    
    print_info "Installing Node.js dependencies..."
    npm install
    
    print_info "Building assets..."
    npm run build
    
    print_success "Dependencies installed"
}

configure_environment() {
    print_header "Configuring Environment"
    
    cd $APP_DIR
    
    # Create .env file
    if [ ! -f .env ]; then
        cp .env.example .env
    fi
    
    # Determine APP_URL protocol
    if [ "$INSTALL_SSL" = "yes" ]; then
        APP_URL="https://${DOMAIN_NAME}"
    else
        APP_URL="http://${DOMAIN_NAME}"
    fi
    
    # Update .env file with proper escaping
    sed -i "s|APP_NAME=.*|APP_NAME=\"JobOne.in\"|" .env
    sed -i "s|APP_ENV=.*|APP_ENV=production|" .env
    sed -i "s|APP_DEBUG=.*|APP_DEBUG=false|" .env
    sed -i "s|APP_URL=.*|APP_URL=${APP_URL}|" .env
    
    sed -i "s|DB_CONNECTION=.*|DB_CONNECTION=mysql|" .env
    sed -i "s|DB_HOST=.*|DB_HOST=127.0.0.1|" .env
    sed -i "s|DB_PORT=.*|DB_PORT=3306|" .env
    sed -i "s|DB_DATABASE=.*|DB_DATABASE=${DB_NAME}|" .env
    sed -i "s|DB_USERNAME=.*|DB_USERNAME=${DB_USER}|" .env
    sed -i "s|DB_PASSWORD=.*|DB_PASSWORD=${DB_PASSWORD}|" .env
    
    sed -i "s|CACHE_STORE=.*|CACHE_STORE=file|" .env
    sed -i "s|SESSION_DRIVER=.*|SESSION_DRIVER=file|" .env
    sed -i "s|QUEUE_CONNECTION=.*|QUEUE_CONNECTION=database|" .env
    
    # Generate application key
    php artisan key:generate --force
    
    print_success "Environment configured"
}

set_permissions() {
    print_header "Setting Permissions"
    
    # Set ownership
    sudo chown -R www-data:www-data $APP_DIR
    
    # Set directory permissions
    sudo find $APP_DIR -type d -exec chmod 755 {} \;
    
    # Set file permissions
    sudo find $APP_DIR -type f -exec chmod 644 {} \;
    
    # Set writable directories
    sudo chmod -R 775 $APP_DIR/storage
    sudo chmod -R 775 $APP_DIR/bootstrap/cache
    
    # Ensure www-data owns writable directories
    sudo chown -R www-data:www-data $APP_DIR/storage
    sudo chown -R www-data:www-data $APP_DIR/bootstrap/cache
    
    print_success "Permissions set correctly"
}

setup_application() {
    print_header "Setting Up Application"
    
    cd $APP_DIR
    
    print_info "Creating storage link..."
    sudo -u www-data php artisan storage:link
    
    print_info "Running migrations..."
    sudo -u www-data php artisan migrate --force
    
    print_info "Optimizing application..."
    sudo -u www-data php artisan config:cache
    sudo -u www-data php artisan route:cache
    sudo -u www-data php artisan view:cache
    
    print_success "Application setup complete"
}

configure_nginx() {
    print_header "Configuring Nginx"
    
    # Determine server_name
    if [[ "$DOMAIN_NAME" =~ ^[0-9]+\.[0-9]+\.[0-9]+\.[0-9]+$ ]]; then
        SERVER_NAME="_"
    else
        SERVER_NAME="${DOMAIN_NAME} www.${DOMAIN_NAME}"
    fi
    
    sudo tee /etc/nginx/sites-available/$APP_NAME > /dev/null <<EOF
server {
    listen 80;
    server_name ${SERVER_NAME};
    root ${APP_DIR}/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php index.html;

    charset utf-8;

    # Gzip compression
    gzip on;
    gzip_vary on;
    gzip_min_length 1024;
    gzip_types text/plain text/css text/xml text/javascript application/x-javascript application/xml+rss application/json;

    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php${PHP_VERSION}-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME \$realpath_root\$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
        fastcgi_buffer_size 128k;
        fastcgi_buffers 256 16k;
        fastcgi_busy_buffers_size 256k;
        fastcgi_temp_file_write_size 256k;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }

    # Cache static assets
    location ~* \.(jpg|jpeg|png|gif|ico|css|js|svg|woff|woff2|ttf|eot)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }
}
EOF
    
    sudo ln -sf /etc/nginx/sites-available/$APP_NAME /etc/nginx/sites-enabled/
    sudo rm -f /etc/nginx/sites-enabled/default
    
    sudo nginx -t
    sudo systemctl reload nginx
    
    print_success "Nginx configured"
}

install_ssl() {
    if [ "$INSTALL_SSL" = "yes" ]; then
        print_header "Installing SSL Certificate"
        
        print_info "Installing Certbot..."
        sudo apt install certbot python3-certbot-nginx -y
        
        print_info "Obtaining SSL certificate..."
        sudo certbot --nginx -d ${DOMAIN_NAME} -d www.${DOMAIN_NAME} --non-interactive --agree-tos --email ${SSL_EMAIL} --redirect || {
            print_warning "SSL installation failed. Site will run on HTTP."
            print_info "You can install SSL later with: sudo certbot --nginx -d ${DOMAIN_NAME}"
        }
        
        print_success "SSL certificate installation attempted"
    else
        print_info "Skipping SSL installation"
    fi
}

configure_supervisor() {
    print_header "Configuring Queue Workers"
    
    sudo tee /etc/supervisor/conf.d/${APP_NAME}-worker.conf > /dev/null <<EOF
[program:${APP_NAME}-worker]
process_name=%(program_name)s_%(process_num)02d
command=php ${APP_DIR}/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=${APP_DIR}/storage/logs/worker.log
stopwaitsecs=3600
EOF
    
    sudo supervisorctl reread
    sudo supervisorctl update
    sudo supervisorctl start ${APP_NAME}-worker:* || print_warning "Queue workers will start on next reboot"
    
    print_success "Queue workers configured"
}

configure_cron() {
    print_header "Configuring Scheduled Tasks"
    
    # Remove existing cron job if present
    sudo crontab -u www-data -l 2>/dev/null | grep -v "artisan schedule:run" | sudo crontab -u www-data - || true
    
    # Add new cron job
    (sudo crontab -u www-data -l 2>/dev/null; echo "* * * * * cd ${APP_DIR} && php artisan schedule:run >> /dev/null 2>&1") | sudo crontab -u www-data -
    
    print_success "Cron jobs configured"
}

create_admin_user() {
    print_header "Creating Admin User"
    
    cd $APP_DIR
    
    # Create admin user using artisan tinker
    sudo -u www-data php artisan tinker <<EOF
\$admin = App\Models\Admin::firstOrNew(['email' => '${ADMIN_EMAIL}']);
\$admin->name = 'Admin';
\$admin->email = '${ADMIN_EMAIL}';
\$admin->password = bcrypt('${ADMIN_PASSWORD}');
\$admin->save();
echo "Admin user created\n";
exit
EOF
    
    print_success "Admin user created"
}

generate_sitemap() {
    print_header "Generating Sitemap"
    
    cd $APP_DIR
    
    # Check if sitemap command exists
    if sudo -u www-data php artisan list | grep -q "sitemap:generate"; then
        sudo -u www-data php artisan sitemap:generate || print_warning "Sitemap generation skipped"
    else
        print_info "Sitemap command not available, skipping"
    fi
    
    print_success "Sitemap step complete"
}

configure_firewall() {
    print_header "Configuring Firewall"
    
    if command -v ufw &> /dev/null; then
        sudo ufw allow 22/tcp
        sudo ufw allow 80/tcp
        sudo ufw allow 443/tcp
        echo "y" | sudo ufw enable
        print_success "Firewall configured"
    else
        print_warning "UFW not installed, skipping firewall configuration"
    fi
}

print_summary() {
    print_header "Installation Complete!"
    
    # Determine protocol
    if [ "$INSTALL_SSL" = "yes" ]; then
        PROTOCOL="https"
    else
        PROTOCOL="http"
    fi
    
    echo -e "${GREEN}╔═══════════════════════════════════════════════════════════════╗${NC}"
    echo -e "${GREEN}║                  Installation Summary                         ║${NC}"
    echo -e "${GREEN}╚═══════════════════════════════════════════════════════════════╝${NC}"
    echo
    echo -e "${BLUE}Website URL:${NC}        ${PROTOCOL}://${DOMAIN_NAME}"
    echo -e "${BLUE}Admin URL:${NC}          ${PROTOCOL}://${DOMAIN_NAME}/admin/login"
    echo -e "${BLUE}Admin Email:${NC}        ${ADMIN_EMAIL}"
    echo -e "${BLUE}Admin Password:${NC}     ${ADMIN_PASSWORD}"
    echo
    echo -e "${BLUE}Database Details:${NC}"
    echo -e "  Database Name:     ${DB_NAME}"
    echo -e "  Database User:     ${DB_USER}"
    echo -e "  Database Password: ${DB_PASSWORD}"
    echo -e "  ${YELLOW}(Saved in ${APP_DIR}/.env)${NC}"
    echo
    echo -e "${YELLOW}Important Next Steps:${NC}"
    echo -e "  1. Visit your website: ${PROTOCOL}://${DOMAIN_NAME}"
    echo -e "  2. Login to admin panel: ${PROTOCOL}://${DOMAIN_NAME}/admin/login"
    echo -e "  3. Change admin password immediately"
    echo -e "  4. Add content and configure site settings"
    echo -e "  5. Submit sitemap to Google Search Console"
    echo
    echo -e "${BLUE}Application Directory:${NC} ${APP_DIR}"
    echo -e "${BLUE}Logs Location:${NC}        ${APP_DIR}/storage/logs"
    echo -e "${BLUE}Nginx Config:${NC}         /etc/nginx/sites-available/${APP_NAME}"
    echo
    echo -e "${GREEN}✓ JobOne.in is now live and ready to use!${NC}"
    echo
    
    # Save credentials to file
    cat > /tmp/jobone-credentials.txt <<CREDS
JobOne.in Installation Credentials
===================================

Website: ${PROTOCOL}://${DOMAIN_NAME}
Admin Panel: ${PROTOCOL}://${DOMAIN_NAME}/admin/login

Admin Login:
  Email: ${ADMIN_EMAIL}
  Password: ${ADMIN_PASSWORD}

Database:
  Name: ${DB_NAME}
  User: ${DB_USER}
  Password: ${DB_PASSWORD}

Application Directory: ${APP_DIR}
Logs: ${APP_DIR}/storage/logs

Installation Date: $(date)
CREDS
    
    print_info "Credentials saved to: /tmp/jobone-credentials.txt"
}

###############################################################################
# Main Installation Flow
###############################################################################

main() {
    clear
    
    echo -e "${BLUE}"
    cat << "EOF"
    ╔═══════════════════════════════════════════════════════════════╗
    ║                                                               ║
    ║              JobOne.in - One-Click Installer                  ║
    ║          Government Job Portal Deployment Script              ║
    ║                    FIXED VERSION v2.0                         ║
    ║                                                               ║
    ╚═══════════════════════════════════════════════════════════════╝
EOF
    echo -e "${NC}\n"
    
    check_root
    
    print_warning "This script will install and configure JobOne.in on this server."
    print_warning "Estimated time: 10-15 minutes"
    print_info "All previous deployment issues have been fixed"
    echo
    read -p "$(echo -e ${YELLOW}Do you want to continue? [y/N]: ${NC})" -n 1 -r
    echo
    
    if [[ ! $REPLY =~ ^[Yy]$ ]]; then
        print_error "Installation cancelled"
        exit 1
    fi
    
    # Collect configuration
    collect_configuration
    
    # Start installation
    update_system
    install_nginx
    install_php
    install_mysql
    configure_mysql
    install_composer
    install_nodejs
    install_supervisor
    clone_repository
    install_dependencies
    configure_environment
    set_permissions
    setup_application
    configure_nginx
    install_ssl
    configure_supervisor
    configure_cron
    create_admin_user
    generate_sitemap
    configure_firewall
    
    # Print summary
    print_summary
}

# Run main function
main "$@"
