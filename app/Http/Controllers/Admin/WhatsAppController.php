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
        
        $emoji = match($post->type) {
            'job' => '💼',
            'result' => '📊',
            'admit_card' => '🎫',
            'answer_key' => '✅',
            'syllabus' => '📚',
            'blog' => '📝',
            default => '📢'
        };
        
        $message = "{$emoji} *{$post->title}*\n\n";
        
        if ($post->type === 'job') {
            if ($post->total_vacancies) {
                $message .= "📊 *Vacancies:* {$post->total_vacancies}\n";
            }
            if ($post->education) {
                $educationLabels = $this->getEducationLabels($post->education);
                $message .= "🎓 *Education:* {$educationLabels}\n";
            }
            if ($post->state_id) {
                $message .= "📍 *State:* {$post->state->name}\n";
            } else {
                $message .= "📍 *Location:* All India\n";
            }
            if ($post->last_date) {
                $message .= "⏰ *Last Date:* " . date('d M Y', strtotime($post->last_date)) . "\n";
            }
        }
        
        $message .= "\n🔗 *Apply/Details:*\n{$url}\n\n";
        $message .= "━━━━━━━━━━━━━━━━\n";
        $message .= "📱 *JoBone.in* - Latest Govt Jobs\n";
        $message .= "🔔 Join: https://jobone.in";
        
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
