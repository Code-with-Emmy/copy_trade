<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim((string) $slot) !== '')
{!! $slot !!}
@else
<span class="wordmark">{{ config('app.name') }}</span>
@endif
</a>
</td>
</tr>
