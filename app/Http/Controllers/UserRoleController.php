<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use OpenApi\Annotations as OA;

class UserRoleController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/users/assign-role",
     *     summary="Assign a role to a user",
     *     tags={"User Roles"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_id", "role_id"},
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="role_id", type="integer", example=2)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Role assigned successfully"),
     *     @OA\Response(response=422, description="Validation error"),
     *     @OA\Response(response=404, description="User or Role not found")
     * )
     */
    public function assignRole(Request $request) {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id'
        ]);

        $user = User::findOrFail($request->user_id);
        $role = Role::findOrFail($request->role_id);
        $user->assignRole($role);

        return response()->json(['message' => 'Role assigned to user']);
    }

    /**
     * @OA\Post(
     *     path="/api/users/remove-role",
     *     summary="Remove a role from a user",
     *     tags={"User Roles"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_id", "role_id"},
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="role_id", type="integer", example=2)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Role removed successfully"),
     *     @OA\Response(response=422, description="Validation error"),
     *     @OA\Response(response=404, description="User or Role not found")
     * )
     */
    public function removeRole(Request $request) {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id'
        ]);

        $user = User::findOrFail($request->user_id);
        $role = Role::findOrFail($request->role_id);
        $user->removeRole($role);

        return response()->json(['message' => 'Role removed from user']);
    }
}
