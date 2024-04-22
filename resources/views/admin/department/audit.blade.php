<div class="row">
    <div class="col-lg-12">
        <h4>Comparison Table</h4>
        @if ($auditLog->old_values || $auditLog->new_values)
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Column</th>
                        <th>Old Data</th>
                        <th>New Data</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($auditLog->old_values as $key => $oldValue)
                        <tr>
                            <td>{{ str_replace(['_', 'ID'], [' ', ''], strtoupper($key)) }}</td>
                            <td>
                                @if($key === 'is_active')
                                    <x-is-active-badge :isActive="$oldValue" />
                                @else
                                    {{ $oldValue }}
                                @endif
                            </td>
                            <td>
                                @if($key === 'is_active')
                                    <x-is-active-badge :isActive="$auditLog->new_values[$key] ?? ''" />
                                @else
                                    {{ $auditLog->new_values[$key] ?? '' }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    @foreach ($auditLog->new_values as $key => $newValue)
                        @unless (array_key_exists($key, $auditLog->old_values))
                            <tr>
                                <td>{{ str_replace(['_', 'ID'], [' ', ''], strtoupper($key)) }}</td>
                                <td></td>
                                <td>
                                    @if($key === 'is_active')
                                        <x-is-active-badge :isActive="$newValue" />
                                    @else
                                        {{ $newValue }}
                                    @endif
                                </td>
                            </tr>
                        @endunless
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No values available.</p>
        @endif
    </div>
</div>
