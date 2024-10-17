<?php

namespace App\Http\Controllers\Api;

use App\Enums\StatusProfil;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Profil\CreateRequest;
use App\Http\Requests\Api\Profil\UpdateRequest;
use App\Http\Resources\ProfilResource;
use App\Models\Profil;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;

class ProfilController extends Controller
{
    public function create(CreateRequest $request): JsonResponse
    {
        $path = $request->file('image')->store('images');

        $profil = new Profil();
        $profil->nom = $request->nom;
        $profil->prenom = $request->prenom;
        $profil->image = $path;
        $profil->status = $request->status;
        $profil->save();

        return response()->json($profil, 201);
    }

    public function index(): JsonResource
    {
        // On peut ajouter de la pagination
        return ProfilResource::collection(Profil::where('status', StatusProfil::ACTIF)->paginate(3));
    }

    public function update(UpdateRequest $request, Profil $profil): JsonResponse
    {

        $profil->update($request->validated());
        return response()->json(['message' => 'Profil updated successfully'], Response::HTTP_OK);
    }

    public function delete(Profil $profil): JsonResponse
    {
        $profil->delete();

        // On pourrait retournée une 204 si on ne renseigne pas de message dans le body de la requete.
        return response()->json(['message' => 'Profil deleted successfully'], Response::HTTP_OK);
    }
}
