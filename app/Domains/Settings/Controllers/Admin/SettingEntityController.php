<?php

namespace App\Domains\Settings\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Domains\Settings\Repositories\SettingEntityRepository;
use App\Domains\Settings\Requests\SettingRequest;
use Illuminate\Http\Request;

class SettingEntityController extends Controller
{
    protected $repository;

    public function __construct(SettingEntityRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $settings = $this->repository->all()->first();

        $titlePage = 'الإعدادات';
        return view('settings::admin.index', compact('settings', 'titlePage'));
    }

    public function update(SettingRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('settings', 'public');
        }

        if ($request->hasFile('brand_image')) {
            $validated['brand_image'] = $request->file('brand_image')->store('settings', 'public');
        }

        $this->repository->save($validated);

        return redirect()->back()->with([
            'swal' => [
                'title' => 'تم حفظ الإعدادات بنجاح',
                'text'  => '',
                'type'  => 'success',
            ]
        ]);
    }
}
