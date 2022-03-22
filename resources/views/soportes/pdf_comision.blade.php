<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Document</title>
        <style>
        h1{
        text-align: center;
        text-transform: uppercase;
        }
        .bg-color {
            background-color: #a3e4ff;
            font-weight: bold;
        }
        table {
            margin: 0px;
            width: 100%;
            border-collapse: collapse;
            text-align: center;
            font-family: Arial, Helvetica, sans-serif;
        }
        td {
            padding: 5px;
        }
        .txt-bold {
            font-weight: bold;
        }
    </style>
    </head>
    <body>
        {{-- <h1>Titulo de prueba</h1>
        <hr> --}}
        <span style="font-family: Arial, Helvetica, sans-serif; font-size:12px">Reporte generado en la fecha {{ Carbon\Carbon::parse($currentDate)->format('Y-m-d g:ia') }}</span>
        <table border="1">
            <tr>
                <td>ID de la comisión</td>
                <td>{{$comision->id}}</td>
            </tr>
            <tr>
                <td colspan="2" class="bg-color">DATOS GENERALES DE LA COMISIÓN</td>
            </tr>
        </table>

        <table border="1">
            <tr>
                <td class="txt-bold">No. de Aprobación</td>
                <td class="txt-bold">Nombre Del Esquema</td>
                <td class="txt-bold">No. Días Aprobados</td>
            </tr>
            <tr>
                <td>{{$comision->numero}}</td>
                <td>{{$comision->cliente->nombre}}</td>
                <td>{{$comision->dias_aprobados}}</td>
            </tr>
            <tr>
                <td class="txt-bold" colspan="2">Estado</td>
                {{-- <td class="txt-bold">Nombre Del Esquema</td> --}}
                <td class="txt-bold">Días reales</td>
            </tr>
            <tr>
                <td colspan="2">{{$comision->estado_texto}}</td>
                <td>{{$comision->dias_reales}}</td>
            </tr>
            <tr>
                <td class="txt-bold" colspan="3">OBSERVACIONES UNP</td>
            </tr>
            <tr>
                <td colspan="3">{{$observacionesUNP}}</td>
            </tr>
            <tr>
                <td colspan="3" class="bg-color">DATOS GENERALES DE LA COMISIÓN</td>
            </tr>
            <tr>
                <td class="txt-bold">Identificación</td>
                <td class="txt-bold">Nombres</td>
                <td class="txt-bold">Apellidos</td>
            </tr>
            <tr>
                <td>{{$comision->escolta->identificacion}}</td>
                <td>{{$comision->escolta->nombre}}</td>
                <td>{{$comision->escolta->apellidos}}</td>
            </tr>
        </table>

        <table border="1">
            <tr>
                <td class="txt-bold">Celular Corporativo</td>
                <td class="txt-bold">Ciudad Origen</td>
            </tr>
            <tr>
                <td>{{$comision->escolta->celular}}</td>
                <td>{{$comision->escolta->ciudad_origen}}</td>
            </tr>
        </table>

        <table border="1">
            <tr>
                <td colspan="3" class="bg-color">DESTINOS AUTORIZADOS</td>
            </tr>
            <tr>
                <td class="txt-bold">Departamento</td>
                <td class="txt-bold">Lugar</td>
                <td class="txt-bold">Fecha y hora reporte</td>
            </tr>
            @foreach ($comision->reportes_ordenados as $reporte)
                <tr>
                    <td>{{$reporte->departamento->nombre}}</td>
                    <td>{{$reporte->lugar}}</td>
                    <td>
                        @if (!empty($reporte->fecha_reporte))
                            {{ Carbon\Carbon::parse($reporte->fecha_reporte)->format('d/m/Y g:i A') }}
                        @endif
                    </td>
                </tr>
            @endforeach

        </table>
    </body>
</html>