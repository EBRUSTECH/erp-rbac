<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Role",
 *     type="object",
 *     required={"id", "name"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Admin")
 * )
 */

class RoleController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/roles",
     *     summary="Get all roles",
     *     tags={"Roles"},
     *     @OA\Response(
     *         response=200,
     *         description="List of roles",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Role"))
     *     )
     * )
     */
    public function index() {
        return response()->json(Role::all());
    }

    /**
     * @OA\Post(
     *     path="/api/roles",
     *     summary="Create a new role",
     *     tags={"Roles"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Admin")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Role created successfully"),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function store(Request $request) {
        $request->validate(['name' => 'required|unique:roles']);
        $role = Role::create(['name' => $request->name]);
        return response()->json($role, 201);
    }

    /**
     * @OA\Put(
     *     path="/api/roles/{id}",
     *     summary="Update a role",
     *     tags={"Roles"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the role to update",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Editor")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Role updated successfully"),
     *     @OA\Response(response=422, description="Validation error"),
     *     @OA\Response(response=404, description="Role not found")
     * )
     */
    public function update(Request $request, Role $role) {
        $request->validate(['name' => 'required|unique:roles,name,'.$role->id]);
        $role->update(['name' => $request->name]);
        return response()->json($role);
    }

    /**
     * @OA\Delete(
     *     path="/api/roles/{id}",
     *     summary="Delete a role",
     *     tags={"Roles"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the role to delete",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Role deleted successfully"),
     *     @OA\Response(response=404, description="Role not found")
     * )
     */
    public function destroy(Role $role) {
        $role->delete();
        return response()->json(['message' => 'Role deleted']);
    }
}
