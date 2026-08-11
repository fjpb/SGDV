<x-app-layout>

<div class="container-xl">

    <div class="page-header d-print-none">

        <div class="row align-items-center">

            <div class="col">

                <h2 class="page-title">
                    Documentos archivados
                </h2>

                <div class="text-secondary">
                    Documentos eliminados lógicamente mediante SoftDeletes.
                </div>

            </div>

        </div>

    </div>

    <div class="card">

        <div class="card-header">

            <h3 class="card-title">
                Papelera documental
            </h3>

        </div>


        <div class="table-responsive">

            <table class="table card-table table-vcenter">

                <thead>

                    <tr>

                        <th>
                            Documento
                        </th>

                        <th>
                            Tipo
                        </th>

                        <th>
                            Vehículo
                        </th>

                        <th>
                            Archivado
                        </th>

                        <th>
                            Usuario
                        </th>

                        <th class="w-1">
                            Acción
                        </th>

                    </tr>

                </thead>


                <tbody>


                @forelse($documents as $document)

                    @php

                        $audit = $document->auditLogs
                            ->where('accion','eliminacion')
                            ->sortByDesc('created_at')
                            ->first();

                    @endphp


                    <tr>

                        <td>

                            {{ $document->nombre }}

                        </td>


                        <td>

                            {{ $document->tipo_documento }}

                        </td>


                        <td>

                            {{ $document->vehicle->patente ?? '-' }}

                        </td>


                        <td>

                            {{ $document->deleted_at
                                ? $document->deleted_at->format('d-m-Y H:i')
                                : '-'
                            }}

                        </td>


                        <td>

                            {{ $audit?->user?->name ?? '-' }}

                        </td>


                        <td>

                            <form method="POST"
                                action="{{ route('documents.trash.restore',$document->id) }}">

                                @csrf

                                <button class="btn btn-success btn-sm">

                                    Restaurar

                                </button>

                            </form>

                        </td>


                    </tr>


                @empty

                    <tr>

                        <td colspan="6"
                            class="text-center text-secondary">

                            No existen documentos archivados.

                        </td>

                    </tr>


                @endforelse


                </tbody>

            </table>

        </div>

    </div>


</div>

</x-app-layout>
