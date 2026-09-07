<?php

namespace App\Policies;

use App\Models\Document;
use App\Models\User;

class DocumentPolicy
{

    /**
     * Permite acceso administrativo completo.
     */
    private function isAdminOrSupervisor(User $user): bool
    {
        return $user->isAdmin()
            || $user->isSupervisor();
    }


    /**
     * Ver documento.
     */
    public function view(
        User $user,
        Document $document
    ): bool
    {

        if ($this->isAdminOrSupervisor($user)) {
            return true;
        }


        return $document->vehicle
            && $document->vehicle->user_id === $user->id;

    }


    /**
     * Crear documento.
     */
    public function create(
        User $user
    ): bool
    {
        return true;
    }


    /**
     * Editar documento.
     */
    public function update(
        User $user,
        Document $document
    ): bool
    {

        if ($this->isAdminOrSupervisor($user)) {
            return true;
        }


        return $document->vehicle
            && $document->vehicle->user_id === $user->id;

    }


    /**
     * Eliminar documento.
     */
    public function delete(
        User $user,
        Document $document
    ): bool
    {

        if ($this->isAdminOrSupervisor($user)) {
            return true;
        }


        return $document->vehicle
            && $document->vehicle->user_id === $user->id;

    }


    /**
     * Restaurar documento archivado.
     */
    public function restore(
        User $user,
        Document $document
    ): bool
    {

        return $this->isAdminOrSupervisor($user);

    }


    /**
     * Eliminación definitiva.
     */
    public function forceDelete(
        User $user,
        Document $document
    ): bool
    {

        return $user->isAdmin();

    }

}
