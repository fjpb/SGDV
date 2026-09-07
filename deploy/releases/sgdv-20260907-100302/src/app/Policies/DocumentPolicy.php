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
        return $user->isActive()
            && (
                $user->isAdmin()
                || $user->isSupervisor()
            );
    }

    /**
     * Listar documentos propios.
     */
    public function viewAny(User $user): bool
    {
        return $user->isActive();
    }


    /**
     * Ver documento.
     */
    public function view(
        User $user,
        Document $document
    ): bool
    {

        if (! $user->isActive()) {
            return false;
        }

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
        return $user->isActive();
    }


    /**
     * Editar documento.
     */
    public function update(
        User $user,
        Document $document
    ): bool
    {

        if (! $user->isActive()) {
            return false;
        }

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

        if (! $user->isActive()) {
            return false;
        }

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

        return $user->isActive() && $user->isAdmin();

    }

    /**
     * Consultar reportes documentales globales.
     */
    public function viewReports(User $user): bool
    {
        return $this->isAdminOrSupervisor($user);
    }

    /**
     * Consultar documentos archivados.
     */
    public function viewTrashed(User $user): bool
    {
        return $this->isAdminOrSupervisor($user);
    }

}
