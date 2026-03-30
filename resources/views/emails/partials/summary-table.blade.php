@if (!empty($rows))
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" class="summary-card">
    @foreach ($rows as $row)
        @php
            $label = $row['label'] ?? null;
            $value = $row['value'] ?? null;
        @endphp
        @if ($label !== null && $value !== null && $value !== '')
            <tr>
                <td class="summary-label">{{ $label }}</td>
                <td class="summary-value">{!! $value !!}</td>
            </tr>
        @endif
    @endforeach
</table>
@endif
