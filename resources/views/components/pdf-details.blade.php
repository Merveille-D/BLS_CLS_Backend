@props(['details'])

<table class="details-table">
    <tbody>
        @foreach ($details as $key => $item)
            <tr>
                <td>{{ $key }}</td>
                <td>
                    <div class="text-right">
                        {{ $item }}
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
