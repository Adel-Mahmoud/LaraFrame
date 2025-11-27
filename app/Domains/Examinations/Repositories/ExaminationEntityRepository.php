<?php

namespace App\Domains\Examinations\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Domains\Drugs\Models\DrugEntity;
use App\Domains\Visits\Models\VisitEntity;
use App\Domains\Examinations\Models\ExaminationEntity;
use App\Domains\Examinations\Models\PrescriptionDrugs;
use App\Domains\Drugs\Repositories\DrugEntityRepository;
use App\Domains\Examinations\Models\ExaminationAttachment;

class ExaminationEntityRepository
{
    // public function getNowVisitInQueue()
    // {
    //     return VisitEntity::where('status', 'pending')
    //         ->with('patient')
    //         ->orderBy('visit_date', 'asc')
    //         ->orderBy('visit_time', 'asc')
    //         ->orderBy('id', 'asc')
    //         ->first();
    // }
    public function getNowVisitInQueue($visitID = null)
    {
        try {
            if ($visitID) {
                $nowVisit = VisitEntity::where('id', $visitID)
                    ->with('patient')
                    ->first();

                if (!$nowVisit) {
                    throw new \Exception("الزيارة غير موجودة");
                }

                if ($nowVisit->status !== 'pending') {
                    throw new \Exception("الزيارة ليست في حالة انتظار");
                }
            } else {
                $nowVisit = VisitEntity::where('status', 'pending')
                    ->with('patient')
                    ->orderBy('visit_date', 'asc')
                    ->orderBy('visit_time', 'asc')
                    ->orderBy('id', 'asc')
                    ->first();

                if (!$nowVisit) {
                    return [
                        'now' => null,
                        'last_completed' => null,
                        'message' => 'لا توجد زيارات في قائمة الانتظار'
                    ];
                }
            }

            $lastCompleted = VisitEntity::where('patient_id', $nowVisit->patient_id)
                ->where('status', 'completed')
                ->orderBy('visit_date', 'desc')
                ->orderBy('visit_time', 'desc')
                ->orderBy('id', 'desc')
                ->first();

            return [
                'now' => $nowVisit,
                'last_completed' => $lastCompleted,
                'message' => 'success'
            ];
        } catch (\Exception $e) {
            return [
                'now' => null,
                'last_completed' => null,
                'message' => $e->getMessage()
            ];
        }
    }

    public function getDrugs()
    {
        return DrugEntity::all();
    }

    public function store($request)
    {
        return DB::transaction(function () use ($request) {

            $visit = VisitEntity::findOrFail($request->visit_id);

            $examination = ExaminationEntity::create([
                'visit_id' => $visit->id,
                'patient_id' => $visit->patient_id,
                'symptoms' => $request->symptoms,
                'diagnosis' => $request->diagnosis,
                'test_type' => $request->test_type,
                'test_details' => $request->test_details,
                'notes' => $request->notes,
                'tests_type' => $request->testType,
                'tests_details' => $request->tests_details,
                'created_by' => auth('admin')->id(),
            ]);
 
            if ($request->drugs) {
                // $drugRepo = new DrugEntityRepository;
                foreach ($request->drugs as $drug) {
                    PrescriptionDrugs::create([
                        'examination_id' => $examination->id,
                        'drug_name' => $drug['name'],
                        'dose' => $drug['dose'] ?? null,
                        'duration' => $drug['duration'] ?? null,
                        'form' => $drug['form'] ?? null,
                        'instructions' => $drug['instructions'] ?? null,
                        'created_by' => auth('admin')->id(),
                    ]);
                    // $drugRepo->create([
                    //     "name"=>$drug['name']
                    // ]);
                }
            }

            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $path = $file->store('examination_attachments', 'public');
                    ExaminationAttachment::create([
                        'examination_id' => $examination->id,
                        'file_path' => $path,
                        'file_type' => $file->getClientMimeType(),
                        'created_by' => auth('admin')->id()
                    ]);
                }
            }

            $today = Carbon::today();

            $visit->update([
                'status' => 'completed',
                'visit_date' => $today,
                'visit_time' => now()->format('H:i'),
                'created_at' => $today,
            ]);

            // return $examination;
            return $examination->id;
        });
    }

    public function getVisitById($id)
    {
        return ExaminationEntity::with(['visit', 'drugs', 'attachments'])
            ->findOrFail($id);
    }
}
