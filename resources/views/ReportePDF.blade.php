<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte PDF</title>
    <style>
    /* http://meyerweb.com/eric/tools/css/reset/
        v2.0 | 20110126
        License: none (public domain)
        */
        a,abbr,acronym,address,applet,article,aside,audio,b,big,blockquote,body,canvas,caption,center,cite,code,dd,del,details,dfn,div,dl,dt,em,embed,fieldset,figcaption,figure,footer,form,h1,h2,h3,h4,h5,h6,header,hgroup,html,i,iframe,img,ins,kbd,label,legend,li,mark,menu,nav,object,ol,output,p,pre,q,ruby,s,samp,section,small,span,strike,strong,sub,summary,sup,time,tt,u,ul,var,video{margin:0;padding:0;border:0;font-size:100%;font:inherit;vertical-align:baseline}article,aside,details,figcaption,figure,footer,header,hgroup,menu,nav,section{display:block}body{line-height:1}ol,ul{list-style:none}blockquote,q{quotes:none}blockquote:after,blockquote:before,q:after,q:before{content:'';content:none}table{border-collapse:collapse;border-spacing:0}strong{font-weight:700}
        body { font-family: Arial, Helvetica, sans-serif; font-size: 15px; }
    </style>
</head>
<body>
<div style="display:block; padding: 2% 5%; margin: 0 auto;">
    <!--INFO CNE-->
    <table style="width: 100%; padding: 20px 0px; border: 2px solid #000;">
        <thead>
            <tr>
                <th colspan="3">
                    <img style="display: block; margin: 0px 15px 0 40px" src="images/CNE.png" width="130px; height:120px; ">
                </th>
                <th colspan="3">
                    <table style="width: 100%; padding-left:30px;">
                        <thead>
                            <tr>
                                <th style="border-bottom: 2px solid #000; padding: 8px; font-size:1.3em; font-weight:bolder;">CONSEJO NACIONAL ELECTORAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="border-bottom: 2px solid rgb(49, 49, 49); padding: 12px; font-size:0.9em;">INFORME DE CUMPLIMIENTO RES. 1638/19 MOD. RES.2275/19 - Res. 2670/19</td>
                            </tr>
                            <tr>
                                <td style="border-bottom: 2px solid rgb(49, 49, 49); padding: 3px; font-size:0.9em; font-weight:bold;">TRIBUNALES SECCIONALES DE GARANTIA Y VIGILANCIA ELECTORAL</td>
                            </tr>
                            <tr>
                                <td><br/></td>
                            </tr>
                        </tbody>
                    </table>
                </th>
            </tr>
        </thead>
    </table>
    <!--END INFO CNE-->
    <!--LOOPS-->
    <table style="width: 100%; border: 2px solid #000; margin: -20px 0px -10px;">
        <tbody>
            <tr>
                <td style="width: 100%; padding: 0px;">
                    <table cellspadding="50" style="width: 100%; border-left: 2px solid #000; border-right: 2px solid #000;">
                        <tbody style="display:block; width: 100%;">
                            <tr style="display:table; width: 100%; ">
                                <td><strong style="display: block; padding: 10px;">MAGISTRADO:</strong></td>
                                <td style="margin-left: -15px">{{ $delegado->nombre }}</td>

                                <td style="border-left: 2px solid #000;"><strong style="padding-left: 5px;">DEL:</strong></td>
                                <td>{{ $min_fecha }}</td>
                                <td><strong>AL:</strong></td>
                                <td>{{ $max_fecha }}</td>
                            </tr>
                            <tr style="display:table; width: 78%; border-top: 2px solid #000; padding-top:10px">
                                <td><strong style="display: block; padding: 10px;">DEPARTAMENTO:</strong></td>
                                <td>{{ $delegado->departamento->nombre }}</td>
                                <td style="border-left: 2px solid #000;"><strong style="padding-left: 5px;">CIUDAD:</strong></td>
                                <td>{{ $delegado->ciudad->nombre }}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    <!--END LOOPS-->
    <table style="width: 100%; padding: 0px; border: 2px solid #000; margin: 5px 0 0 0px;">
        <thead style="width: 100%; padding: 20px; background-color: #BFBFBF; margin-top: 5px;">
            <tr>
                <th colspan="4" style="padding: 15px 5px; border-bottom: 1px solid #000;">REPORTE DEL VINCULADO</th>
            </tr>
        </thead>
        <tbody>
            <tr style="padding: 5px; border-bottom: 1px solid #000;">
                <td style="padding: 15px; border-bottom: 1px solid #000"><strong>N°</strong></td>
                <td style="padding: 15px; border-left: 1px solid #000; border-bottom: 1px solid #000"><strong>FECHA</strong></td>
                <td style="padding: 15px; border-left: 1px solid #000; border-right: 1px solid #000;  border-bottom: 1px solid #000"><strong>ACTIVIDADES</strong></td>
                <td style="padding: 15px; border-bottom: 1px solid #000"><strong>GESTIÓN REALIZADA</strong></td>
            </tr>
            @php
                $x = 1;
            @endphp
            @foreach ($data as $row)
            <tr>
                <td style="padding: 20px; border-bottom: 1px solid #000">{{ $x++ }}</td>
                <td style="padding: 20px; border-left: 1px solid #000; border-bottom: 1px solid #000">{{ $row->fecha }}</td>
                <td style="padding: 20px; vertical-align: middle; border-left: 1px solid #000;  border-right: 1px solid #000; border-bottom: 1px solid #000">
                    <ul style="list-style: none">
                        <li style="list-style:none; display: block; height: 50px; line-height: 0.7em;"><strong>Tipo de actividad:</strong>  <p style="display: inline-block; margin-top: 2px; border-bottom: 1px solid #000">{{ $row->tipoActividad->nombre }}</p></li>
                        <li style="list-style:none; display: block;  line-height: 0.7em; "><strong>Tema:</strong><p style="display: inline-block;  margin-top: 2px; text-align: justify; padding-right: 45px;">{{ $row->tema }} </p></li>
                    </ul>
                </td>
                <td style="padding: 20px; border-bottom: 1px solid #000">
                    {{ $row->descripcion }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <table style="width: 100%; padding: 0px; border-left: 2px solid #000; border-right: 2px solid #000;">
        <thead style="width: 100%; background-color: #BFBFBF;">
            <tr>
                <th style="padding: 15px 5px; border-bottom: 1px solid #000;">OBSERVACIONES</th>
            </tr>
        </thead>
        <tbody>
            <tr style="display: table-row; width: 100%;">
                <td style="padding: 50px 20px;"></td>
            </tr>
        </tbody>
    </table>
    <!--CNE SIGNATURES-->
    <table style="width: 100%; padding: 0px 0px;  border: 2px solid #000">
        <thead style="width: 100%; background-color: #BFBFBF;">
            <tr>
                <th colspan="6" style="padding: 15px 5px;  border-bottom: 1px solid #000;">FIRMA MIEMBROS</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="padding: 10px 2%;" colspan="6">
                    <table style="width: 100%;">
                        <tbody>
                            <tr style="width: 100%;">
                                <td width="10%"></td>
                                <td width="30%" style="line-height:1.8em;">
                                    <strong>FIRMA:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;_____________________________<br/>
                                    <strong>NOMBRE:</strong> _____________________________<br/>
                                    <strong>CARGO:</strong> ______________________________<br/>
                                </td>
                                <td colspan="2"></td>
                                <td width="30%" style="line-height:1.8em;">
                                    <strong>FIRMA:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;_____________________________<br/>
                                    <strong>NOMBRE:</strong> _____________________________<br/>
                                    <strong>CARGO:</strong> ______________________________<br/>
                                </td>
                                <td width="10%"></td>
                            </tr>
                            <tr><td colspan="5"></td></tr>
                            <tr style="text-align: center; padding-top:20px;">
                                <td width="10%"></td>
                                <td width="80%" colspan="4" style="line-height:1.8em;">
                                    <strong>FIRMA:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;_____________________________<br/>
                                    <strong>NOMBRE:</strong> _____________________________<br/>
                                    <strong>CARGO:</strong> ______________________________<br/>
                                </td>
                                <td width="10%"></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5">
                                    <strong>VoBo.:</strong>
                                    <br/><br/>
                                    <strong>Cargo:</strong>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    <!--END SIGNATURES-->
</div>
</body>
</html>
