<?php

namespace App\Domains\Roles\Controllers;

use App\Http\Controllers\Controller;
use App\Domains\Roles\Repositories\RoleEntityRepository;
use App\Domains\Roles\Requests\RoleRequest;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RoleEntityController extends Controller
{
    protected RoleEntityRepository $repository;

    public function __construct(RoleEntityRepository $repository)
    {
        $this->repository = $repository;
        // Permissions
        $this->middleware('permission:view roles')->only(['index']);
        $this->middleware('permission:create role')->only(['create', 'store']);
        $this->middleware('permission:edit role')->only(['edit', 'update']);
        $this->middleware('permission:delete role')->only(['destroy']);
    }

    public function index(): View
    {
        $titlePage = 'الأدوار';
        $roles = $this->repository->all();
        return view('roles::admin.index', compact('roles', 'titlePage'));
    }

    public function create(): View
    {
        $sectionPage = 'الأدوار';
        $titlePage = 'دور جديد';
        $permissions = Permission::all();
        return view('roles::admin.create', compact('sectionPage', 'titlePage', 'permissions'));
    }

    public function store(RoleRequest $request): RedirectResponse
    {
        $role = $this->repository->create($request->validated());

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()
            ->route('admin.roles.index')
            ->with('swal', [
                'type'  => 'success',
                'title' => 'تم الإضافة!',
                'text'  => 'تمت إضافة الدور بنجاح.',
            ]);
    }

    public function edit($id): View
    {
        $sectionPage = 'الأدوار';
        $titlePage = 'تعديل دور';
        $role = $this->repository->find($id);
        $permissions = Permission::all();
        return view('roles::admin.edit', compact('role', 'sectionPage', 'titlePage', 'permissions'));
    }

    public function update(RoleRequest $request, $id): RedirectResponse
    {
        $role = $this->repository->update($id, $request->validated());

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()->route('admin.roles.index')->with('success', 'تم تعديل الدور بنجاح');
    }

    public function destroy($id): RedirectResponse
    {
        $this->repository->delete($id);
        return redirect()->route('admin.roles.index')->with('success', 'تم حذف الدور بنجاح');
    }
}
