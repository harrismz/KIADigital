<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pregnancy;
use Illuminate\Http\Request;
use App\Models\WeeklyMonitoringAnswer;
use App\Models\WeeklyMonitoringQuestion;

class PregnancyMonitoringController extends Controller
{
    public function show(Request $request, $week_number)
    {
        $validated = $request->validate([
            'mother_id' => "required"
        ]);

        $mother_id = $validated['mother_id'];

        // get week by date first_day_of_last_period
        $pregnancy = Pregnancy::where('mother_id', $mother_id)->latest()->first();

        // $first_day_of_last_period = $pregnancy->first_day_of_last_period;
        // $week_number = $this->getWeekNumber($first_day_of_last_period)

        // copy to answer
        $answer = $this->generateOrGetAnswer($week_number, $pregnancy->id);
        // return the answer with that data
        return [
            'success' => true,
            'data' => $answer
        ];
    }
    /**
     * Calculate the week number based on the given date.
     *
     * @param string $first_day_of_last_period
     * @return int
     */
    public function getWeekNumber($first_day_of_last_period)
    {
        // Parse the given date
        $start_date = Carbon::parse($first_day_of_last_period);

        // Get the current date
        $current_date = Carbon::now();

        // Calculate the difference in days
        $days_difference = $current_date->diffInDays($start_date);

        // Convert days to weeks
        $week_number = intdiv($days_difference, 7);

        return $week_number;
    }
    public function getWeekPregnancyNumber($mother_id)
    {
        $pregnancy = Pregnancy::where('mother_id', $mother_id)->latest()->first();
        $first_day_of_last_period = $pregnancy->first_day_of_last_period;
        $week_number = $this->getWeekNumber($first_day_of_last_period);
        return $week_number;
    }
    public function generateOrGetAnswer($week_number, $pregnancy_id)
    {
        // get the questions data;
        $questions = WeeklyMonitoringQuestion::get();
        $answers = [];
        foreach ($questions as $question) {
            // dd($question);
            # code...
            $answer = WeeklyMonitoringAnswer::firstOrNew([
                'pregnancy_id' => $pregnancy_id,
                'week_number' => $week_number,
                'weekly_monitoring_question_id' => $question->id,
                'question' => $question->question_text,
            ]);
            if (!$answer->exists) {
                $answer->save();
            }
            $answers[] = $answer;
        }
        return $answers;
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'questions' => 'array|required'
        ]);

        $questions = $validated['questions'];

        $answers = [];
        foreach ($questions as $question) {
            $answer = WeeklyMonitoringAnswer::firstOrNew([
                'pregnancy_id' => $question['pregnancy_id'],
                'week_number' => $question['week_number'],
                'weekly_monitoring_question_id' => $question['weekly_monitoring_question_id'],
                'question' => $question['question'],
            ]);
            $answer->answer = $question['answer'];
            $answer->save();
            $answers[] = $answer;
        }

        return [
            'success' => true,
            'data' => $answers
        ];
    }
}
