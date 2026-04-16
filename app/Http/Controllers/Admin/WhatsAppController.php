<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class WhatsAppController extends Controller
{
    public function index()
    {
        $posts = Post::where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('admin.whatsapp.index', compact('posts'));
    }

    public function generateMessage($id)
    {
        $post = Post::findOrFail($id);
        
        $message = $this->generateWhatsAppMessage($post);
        $whatsappLink = 'https://wa.me/?text=' . urlencode($message);
        
        return response()->json([
            'message' => $message,
            'link' => $whatsappLink,
            'post' => [
                'title' => $post->title,
                'url' => route('posts.show', [$post->type, $post->slug])
            ]
        ]);
    }

    private function generateWhatsAppMessage($post)
    {
        $url = route('posts.show', [$post->type, $post->slug]);
        
        $typeInfo = match($post->type) {
            'job' => ['emoji' => '💼', 'title' => 'New Job Vacancy', 'date_label' => 'Application Start'],
            'admit_card' => ['emoji' => '🎫', 'title' => 'New Admit Card', 'date_label' => 'Release Date'],
            'result' => ['emoji' => '📊', 'title' => 'New Result', 'date_label' => 'Result Date'],
            'answer_key' => ['emoji' => '🔑', 'title' => 'New Answer Key', 'date_label' => 'Release Date'],
            'syllabus' => ['emoji' => '📚', 'title' => 'New Syllabus', 'date_label' => 'Release Date'],
            'blog' => ['emoji' => '📝', 'title' => 'New Article', 'date_label' => 'Published Date'],
            default => ['emoji' => '📢', 'title' => 'New Update', 'date_label' => 'Date']
        };
        
        $message = "{$typeInfo['emoji']} *{$typeInfo['title']}* {$typeInfo['emoji']}\n";
        $message .= "━━━━━━━━━━━━━━━━\n\n";
        $message .= "🔥 *{$post->title}*\n\n";
        
        // Add state
        $stateName = $post->state ? $post->state->name : 'All India';
        $message .= "📍 *State:* {$stateName}\n";
        
        // Add vacancies
        if ($post->total_posts) {
            $message .= "👥 *Total Posts:* {$post->total_posts}\n";
        }
        
        // Add Application Date
        if ($post->notification_date) {
            $message .= "🟣 *{$typeInfo['date_label']}:* " . date('d-m-Y', strtotime($post->notification_date)) . "\n";
        }

        // Add Last Date
        if ($post->last_date) {
            $message .= "🟢 *Last Date:* " . date('d-m-Y', strtotime($post->last_date)) . "\n";
        } else {
            $message .= "🟢 *Last Date:* -\n";
        }
        
        // Add education
        if ($post->education) {
            $educationLabels = $this->getEducationLabels($post->education);
            $message .= "🎓 *Education:* {$educationLabels}\n";
        }
        
        $message .= "\n➡️ *Apply Here:* {$url}\n\n";
        $message .= "#jobone2026 #jobone #{$post->type}";
        
        return $message;
    }

    private function getEducationLabels($education)
    {
        if (empty($education)) {
            return 'Not Specified';
        }

        $labels = [
            '10th' => '10th Pass',
            '12th' => '12th Pass',
            'graduate' => 'Graduate',
            'post_graduate' => 'Post Graduate',
            'diploma' => 'Diploma',
            'iti' => 'ITI',
            'any' => 'Any Qualification'
        ];

        $educationArray = is_array($education) ? $education : json_decode($education, true);
        
        if (!is_array($educationArray)) {
            return 'Not Specified';
        }

        $result = [];
        foreach ($educationArray as $edu) {
            if (isset($labels[$edu])) {
                $result[] = $labels[$edu];
            }
        }

        return !empty($result) ? implode(', ', $result) : 'Not Specified';
    }
}
