<?php
namespace App\Imports;

use App\Models\Competition;
use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use DateTime;
use DateTimeZone;

class CompetitionsImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        $currentCompetition = null; // Current competition
        $currentQuiz = null;        // Current quiz

        foreach ($rows as $row) {
            // Skip empty rows
            if ($row->filter()->isEmpty()) {
                continue;
            }

            // Handle competition rows
            if ($row[0] === 'cuoc-thi') {
                $currentCompetition = Competition::firstOrCreate(
                    ['title' => $row[1]],
                    [
                        'start_date' => $this->excelSerialDateToDateTime($row[2]),
                        'end_date'   => $this->excelSerialDateToDateTime($row[3]),
                        'status'     => $row[4],
                        'time_limit' => $row[5],
                        'banner'     => $row[6] ?? null,
                        'type'       => $row[7] ?? 'competition',
                    ]
                );
            }
            // Handle quiz rows
            elseif ($row[0] === 'bo-cau-hoi' && $currentCompetition) {
                $currentQuiz = Quiz::firstOrCreate(
                    ['title' => $row[1], 'competition_id' => $currentCompetition->id],
                    [
                        'status'            => $row[2],
                        'quantity_question' => $row[3] ?? 0,
                    ]
                );
            }

            elseif ($row[0] == "cau-hoi" && $currentQuiz) {
                $rowData = [];

                foreach ($row as $value) {
                    if ($value !== null && $value !== '') {
                        $rowData[] = $value;
                    }
                }


                $answers = array_slice($rowData, 2, count($rowData) - 3);
                $correctAnswerFormula = $rowData[count($rowData) - 1];


                preg_match('/=([A-Z]+)(\d+)/', $correctAnswerFormula, $matches);
                $correctAnswerColumn = $matches[1];
                $correctAnswerRow = $matches[2];

                $correctAnswerIndex = ord($correctAnswerColumn) - 65;
                $correctAnswerIndex = $correctAnswerIndex - 1;


                $keys = [];
                foreach ($answers as $answer) {
                        $keys[] = uniqid();
                }
                $answers_assoc = array_combine($keys, $answers);
                $answer_true = $keys[$correctAnswerIndex - 1];
                $answer_json = json_encode($answers_assoc, JSON_UNESCAPED_UNICODE);

                Question::create([
                    'quiz_id'       => $currentQuiz->id,
                    'question_name' => $rowData[1],
                    'answer'        => $answer_json,
                    'answer_true'   =>  $answer_true,
                ]);
            }






        }
    }

    /**
     * Convert Excel date or string to DateTime format with UTC timezone.
     */
    function excelSerialDateToDateTime($serialDate)
    {
        if (is_numeric($serialDate)) {

            $unixTime = ($serialDate - 25569) * 86400;
            $date = new DateTime('@' . $unixTime);
            $date->setTimezone(new DateTimeZone('UTC'));
            return $date->format('Y-m-d H:i:s');
        } else {
            $date = new DateTime($serialDate, new DateTimeZone('UTC'));
            return $date->format('Y-m-d H:i:s');
        }
    }

}
