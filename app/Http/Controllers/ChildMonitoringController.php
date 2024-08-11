<?php

namespace App\Http\Controllers;

use App\Models\WeeklyChildMonitoringAnswer;
use App\Models\WeeklyChildMonitoringQuestion;
use App\Models\WeeklyMonitoringAnswer;
use Illuminate\Http\Request;

class ChildMonitoringController extends Controller
{
    //
    public function show(Request $request, $period_id) {
        $validated = $request->validate([
            'child_id' => "required"
        ]);

        $child_id = $validated['child_id'];
        // get the questions data;
        $questions = WeeklyChildMonitoringQuestion ::where('period_id', $period_id)->get();

        // copy to answer
        // $answer = WeeklyChildMonitoringAnswer::
        $answer = $this->generateOrGetAnswer($questions, $child_id);

        // return the answer with that data
        return [
            'success' => true,
            'data' => $answer
        ];
    }

    public function generateOrGetAnswer( $questions, $child_id) {
        $answers = [];
        foreach ($questions as $question) {
            # code...
            $answer = WeeklyChildMonitoringAnswer::firstOrNew([
                'child_id' => $child_id,
                'period_id' => $question->period_id,
                'weekly_child_monitoring_question_id' => $question->id,
                'question' => $question->question_text,
            ]);

            $answer->save();
            
            $answers[] = $answer;
        }

        return $answers;
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'questions' => 'array|required'
        ]);

        $questions = $validated['questions'];

        $answers = [];
        foreach ($questions as $question) {
            # code...
            $answer = WeeklyChildMonitoringAnswer::find($question['id']);
            $answer->answer = $question['answer'];
            $answer->save(); //update the answer
            $answers[]= $answer;
        }

        return [
            'success' => true,
            'data' => $answers,
            'message' => "Data saved!"
        ];
    }
}
