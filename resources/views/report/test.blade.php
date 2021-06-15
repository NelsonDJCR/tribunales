    <br>
    <br>
    <br>
    <!-- CSS only -->
    <div class="margen">


        <div class="row top">
            <img src="./images/cne.png" width="150px">
        </div>

        <div class="" style="justify-content: center; text-align: center"><br><br> <br>
            <h6 style='font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; ; font-size: 15PX;'>LA ASESORÍA DE
                INSPECCIÓN Y VIGILANCIA <br><br> <br> HACE CONSTAR</h6>
        </div>
        <div style="text-align: justify;">
            <P class="text">
                Que de acuerdo a la información que reposa en la Asesoría de Inspección y Vigilancia del Consejo
                Nacional
                Electoral,
                mediante oficio radicado interno No. {{ $radicado }}, la Secretaría General del Concejo Municipal de
                {{ $data->city ?? '' }},
                {{ $data->departamento ?? '' }},
                allegó al Consejo Nacional Electoral copia del registro realizado en relación del Cabildo Abierto
                realizado
                el {{ substr($data->fecha_realizacion, 8, 2) }} de
                @switch( substr($data->fecha_realizacion, 6, 2) )
                    @case('01')
                        enero
                    @break
                    @case('02')
                        febrero
                    @break
                    @case('03')
                        marzo
                    @break
                    @case('04')
                        abril
                    @break
                    @case('05')
                        mayo
                    @break
                    @case('06')
                        junio
                    @break
                    @case('07')
                        julio
                    @break
                    @case('08')
                        agosto
                    @break
                    @case('09')
                        septiembre
                    @break
                    @case('10')
                        ocubre
                    @break
                    @case('11')
                        noviembre
                    @break
                    @default
                        diciembre
                @endswitch
                de {{ substr($data->fecha_realizacion, 0, 4) }}, en el cual se abordó el tema de:
                “{{ $data->nombre_tema ?? '' }}”, de conformidad a
                lo establecido en el artículo 30 de la Ley 1757 de 2015.
                <br><br>
                Se expide en la ciudad de Bogotá D.C, a solicitud del ciudadano {{ $ciudadano }} a los
                @switch(date('d'))
                    @case(1)
                        un
                    @break
                    @case(2)
                        dos
                    @break
                    @case(3)
                        tres
                    @break
                    @case(4)
                        cuatro
                    @break
                    @case(5)
                        | cinco
                    @break
                    @case(6)
                        | seis
                    @break
                    @case(7)
                        | siete
                    @break
                    @case(8)
                        | ocho
                    @break
                    @case(9)
                        | nueve
                    @break
                    @case(10)
                        | diez
                    @break
                    @case(11)
                        | once
                    @break
                    @case(12)
                        doce
                    @break
                    @case(13)
                        trece
                    @break
                    @case(14)
                        catorce
                    @break
                    @case(15)
                        quince
                    @break
                    @case(16)
                        dieciséis
                    @break
                    @case(17)
                        diecisiete
                    @break
                    @case(18)
                        dieciocho
                    @break
                    @case(19)
                        diecinueve
                    @break
                    @case(20)
                        veinete
                    @break
                    @case(21)
                        veintiuno
                    @break
                    @case(22)
                        veintidos
                    @break
                    @case(23)
                        veintitres
                    @break
                    @case(24)
                        veinticuatro
                    @break
                    @case(25)
                        veinticinco
                    @break
                    @case(26)
                        veintiseis
                    @break
                    @case(30)
                        veintisiete
                    @break
                    @case(28)
                        veintiocho
                    @break
                    @case(29)
                        veintinueve
                    @break
                    @case(30)
                        treinta
                    @break
                    @case(31)
                        treinte y uno
                    @break
                    @default
                        [ERROR EN EL SERVIDOR]
                @endswitch
                ({{ date('d') }}) días del mes de
                @switch( date('m') )
                    @case(1)
                        enero
                    @break
                    @case(2)
                        febrero
                    @break
                    @case(3)
                        marzo
                    @break
                    @case(4)
                        abril
                    @break
                    @case(5)
                        mayo
                    @break
                    @case(6)
                        junio
                    @break
                    @case(7)
                        julio
                    @break
                    @case(8)
                        agosto
                    @break
                    @case(9)
                        septiembre
                    @break
                    @case(10)
                        ocubre
                    @break
                    @case(11)
                        noviembre
                    @break
                    @default
                        diciembre
                @endswitch
                del año
                @switch( date('Y') )
                    @case(2021)
                        dos mil veintiuno
                    @break
                    @case(2022)
                        dos mil veintidos
                    @break
                    @case(2023)
                        dos mil veintitre
                    @break
                    @case(2024)
                        dos mil veinticuatro
                    @break
                    @case(2025)
                        dos mil veinticinco
                    @break
                    @case(2026)
                        dos mil veintiseis
                    @break
                    @case(2027)
                        dos mil veintisiete
                    @break
                    @case(2028)
                        dos mil veintiocho
                    @break
                    @case(2029)
                        dos mil veintinueve
                    @break
                    @case(2030)
                        dos mil terinta
                    @break
                    @case(2031)
                        dos mil treinta y uno
                    @break
                    [ERROR DEL SERVIDOR]
                    @default
                @endswitch
                ({{ date('Y') }}).
            </p>
        </div>
        <div style="justify-content: center; text-align: center">
            <h5 class="signature">{{ strtoupper(Auth::user()->usuario) }} <br>Asesor de Inspección Y Vigilancia </h5>
            <p class="signature_data">Consejo nacional electoral</p>
        </div>
        <footer>
            <div class="box">
                <p class="pie">Proyecto: SBC</p>
                <p class="pie">Reviso: MSR</p>
            </div>
            <p class="marca">Asesoría Inspección y Vigilancia - Consaejo Nacional Electoral</p>
            <p class="marca">Avenida Calle 26 No. 15-50 CAN PBX. 2200 800 Ext. 1340 - www.cne.gov.vo</p>
        </footer>

    </div>


    <style>
        .margen{
            margin-left: 80px;
            margin-right: 20px;
        }
        .pie {
            line-height: 10px;
            font-size: 10px;
            font-family: Verdana, Tahoma, sans-serif;
        }

        .box {
            margin-top: -50px;
            color: black;
        }

        .signature_data {
            margin-top: -30px;
            font-family: Verdana, Tahoma, sans-serif;
            font-size: 14px;
            font-style: normal;
            font-weight: 400;
            line-height: 25px;
        }

        .signature {
            margin-top: 60px;
            font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
            font-size: 15px;
            line-height: 20px;
        }

        .row {
            margin-top: 20px;
            margin-bottom: 20px;
            width: 100%;
            justify-content: center;
            text-align: center;
        }

        .text {
            font-family: Verdana, Tahoma, sans-serif;
            font-size: 14px;
            font-style: normal;
            font-weight: 400;
            line-height: 25px;
        }

        footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 40px;
            color: black;
            justify-content: end;

        }

        .marca {
            text-align: right;
            font-family: Verdana, Tahoma, sans-serif;
            font-size: 10px;
            font-style: normal;
            font-weight: 400;
            line-height: 1px;
        }

    </style>
