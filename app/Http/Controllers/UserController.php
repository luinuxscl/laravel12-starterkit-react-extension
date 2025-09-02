<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Role;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $q = (string) $request->string('q');
        $sort = (string) $request->string('sort', 'id');
        $dir = strtolower((string) $request->string('dir', 'desc')) === 'asc' ? 'asc' : 'desc';

        $allowedSorts = ['id', 'name', 'email'];
        if (! in_array($sort, $allowedSorts, true)) {
            $sort = 'id';
        }

        $users = User::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('name', 'like', "%{$q}%")
                        ->orWhere('email', 'like', "%{$q}%");
                });
            })
            ->select(['id', 'name', 'email'])
            ->orderBy($sort, $dir)
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('users/index', [
            'users' => $users,
            'filters' => [
                'q' => $q,
                'sort' => $sort,
                'dir' => $dir,
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('users/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();

        $user = User::create($data);

        // Sync roles on create if actor is admin/root
        $acting = $request->user();
        if ($request->has('roles') && $acting && ($acting->hasRole('admin') || $acting->hasRole('root'))) {
            $user->syncRoles($data['roles'] ?? []);
        }

        return redirect()->route('users.index')->with('success', 'Usuario creado');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): Response
    {
        return Inertia::render('users/show', [
            'user' => $user->only(['id', 'name', 'email']),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): Response
    {
        return Inertia::render('users/edit', [
            'user' => $user->only(['id', 'name', 'email']),
            'roles' => Role::query()->orderBy('name')->pluck('name'),
            'userRoles' => $user->getRoleNames(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();

        if (empty($data['password'])) {
            unset($data['password']);
        }

        $user->update($data);

        // Sync roles only if the acting user is admin/root
        $acting = $request->user();
        if ($request->has('roles') && $acting && ($acting->hasRole('admin') || $acting->hasRole('root'))) {
            // Non-root cannot change roles of a root user
            if ($user->hasRole('root') && ! $acting->hasRole('root')) {
                abort(403, 'No autorizado a modificar roles de un usuario root');
            }

            $user->syncRoles($data['roles'] ?? []);
        }

        return redirect()->route('users.show', $user)->with('success', 'Usuario actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Usuario eliminado');
    }
}
