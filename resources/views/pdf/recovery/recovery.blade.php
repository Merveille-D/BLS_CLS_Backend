@extends('pdf.layout')
@section('content')
<div class="container">
    <x-pdf-header :data="$model" :bankLogo="$bankLogo" :blsLogo="$base64Image" />
    <h2>Détail du recouvrement</h2>
    <x-pdf-details :details="$details" />

    @if (!blank($model->tasks))
    <h2>Planification</h2>
    <table class="data-table">
        <thead>
            <tr>
                <th>Libellé</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($model->tasks as $key => $task)
                <tr  class="{{ $task->status ?: 'gray italic' }}">
                    <td>{{ $task->type == 'task' ? $task->title : __('recovery.'.$task->title) }}</td>
                    <td>{{ formatDateTime($task->completed_at) }}</td>
                </tr>
            @endforeach

        </tbody>
    </table>
    @endif

    <div class="footer" id="footer">
        <span class="pagenum"></span>
    </div>
</div>
@endsection
