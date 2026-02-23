<?php

namespace App\Http\Controllers;

use App\Models\SystemInsight;

use App\Models\BookingInvoice;
use App\Models\Dress;
use App\Models\Expense;
use App\Services\GeminiService;
use Illuminate\Http\Request;

class SystemInsightController extends Controller
{
    protected $gemini;

    public function __construct(GeminiService $gemini)
    {
        $this->gemini = $gemini;
    }

    public function index()
    {
        $insights = SystemInsight::latest()->get();
        return view('pages.insights', compact('insights'));
    }

    public function chat(Request $request)
    {
        $request->validate(['message' => 'required|string|max:1000']);
        
        $context = $this->getBusinessContext();
        $prompt = "أنت مساعد ذكي لنظام إدارة فساتين يسمى 'ليالي العمر'. إليك بيانات المحل الحالية:\n{$context}\n\nسؤال المستخدم: {$request->message}\n\nأجب باللغة العربية بأسلوب احترافي وودود.";
        
        $response = $this->gemini->generateResponse($prompt);
        
        return response()->json(['response' => $response]);
    }

    public function generateReport()
    {
        $context = $this->getBusinessContext();
        $prompt = "قم بتحليل البيانات التالية لنظام 'ليالي العمر' وقدم 3 رؤى (Insights) ذكية لتحسين العمل. 
        يجب أن تكون الرؤى بصيغة JSON كقائمة (Array of objects) تحتوي على 'title', 'content', 'level' (INFO, WARNING, CRITICAL).
        البيانات:\n{$context}";

        $response = $this->gemini->generateResponse($prompt);
        
        // Extract JSON using regex if wrapped in markdown code blocks
        if (preg_match('/```json\s*(.*?)\s*```/s', $response, $matches)) {
            $jsonStr = $matches[1];
        } else {
            $jsonStr = trim($response);
        }
        
        $insightsData = json_decode($jsonStr, true);

        if (is_array($insightsData)) {
            foreach ($insightsData as $data) {
                SystemInsight::create($data);
            }
            return back()->with('success', 'تم توليد تحليلات جديدة بنجاح!');
        }

        return back()->with('error', 'فشل في تحليل البيانات بشكل صحيح.');
    }

    protected function getBusinessContext()
    {
        $totalDresses = Dress::count();
        $availableDresses = Dress::where('current_status', 'available')->count();
        $totalBookings = BookingInvoice::count();
        $totalRevenue = BookingInvoice::where('status', '!=', 'cancelled')->sum('total_amount');
        $totalExpenses = Expense::sum('amount');
        $topDresses = Dress::withCount('bookings')->orderBy('bookings_count', 'desc')->take(3)->get();
        
        $context = "إحصائيات:\n";
        $context .= "- إجمالي الفساتين: {$totalDresses} (المتاح منها: {$availableDresses})\n";
        $context .= "- إجمالي الحجوزات: {$totalBookings}\n";
        $context .= "- إجمالي الإيرادات: {$totalRevenue} ر.س\n";
        $context .= "- إجمالي المصروفات: {$totalExpenses} ر.س\n";
        $context .= "أكثر الفساتين طلباً:\n";
        foreach($topDresses as $d) {
            $context .= "- {$d->name} ({$d->bookings_count} حجز)\n";
        }
        
        return $context;
    }

    public function markRead(SystemInsight $insight)
    {
        $insight->update(['is_read' => true]);
        return back()->with('success', 'تم وضع علامة مقروء');
    }
}
