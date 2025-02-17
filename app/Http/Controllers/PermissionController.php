<?php
namespace App\Http\Controllers;

use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Permission",
 *     type="object",
 *     required={"id", "name"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="edit_users")
 * )
 */

class PermissionController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/permissions",
     *     summary="Get all permissions",
     *     tags={"Permissions"},
     *     @OA\Response(
     *         response=200,
     *         description="List of permissions",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Permission"))
     *     )
     * )
     */
    public function index() {
        return response()->json(Permission::all());
    }

    /**
     * @OA\Post(
     *     path="/api/permissions",
     *     summary="Create a new permission",
     *     tags={"Permissions"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="edit_users")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Permission created"),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function store(Request $request) {
        $request->validate(['name' => 'required|unique:permissions']);
        $permission = Permission::create(['name' => $request->name]);
        return response()->json($permission, 201);
    }

    /**
     * @OA\Post(
     *     path="/api/permissions/assign",
     *     summary="Assign a permission to a role",
     *     tags={"Permissions"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"role_id", "permission_id"},
     *             @OA\Property(property="role_id", type="integer", example=1),
     *             @OA\Property(property="permission_id", type="integer", example=2)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Permission assigned to role"),
     *     @OA\Response(response=404, description="Role or Permission not found"),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function assignToRole(Request $request) {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'permission_id' => 'required|exists:permissions,id'
        ]);

        $role = Role::findById($request->role_id);
        $permission = Permission::findById($request->permission_id);
        $role->givePermissionTo($permission);

        return response()->json(['message' => 'Permission assigned to role']);
    }
}
