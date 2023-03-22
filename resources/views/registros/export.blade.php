<table>
    <thead>
        <tr>
            <th>RBD</th>
            <th>Posee RUN</th>
            <th>RUN alumno</th>
            <th>DV alumno</th>
            <th>Annio mensualidad percibida</th>
            <th>Monto total mensualidad</th>
            <th>Monto total intereses y/o gastos de cobranza</th>
            <th>Cantidad de mensualidades</th>
            <th>Tipo de Documento</th>
        </tr>
    </thead>
    <tbody>
        @foreach($registros as $registro)
            <tr>
                @foreach($registro as $key)
                    <td>{{ $key }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>