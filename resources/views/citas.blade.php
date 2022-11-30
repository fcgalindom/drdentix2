<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>

<head>

    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title></title>
    <meta name="generator" content="LibreOffice 7.1.6.2 (Linux)" />
    <meta name="author" content="Hloom.com" />
    <meta name="created" content="2000-07-27T23:18:40" />
    <meta name="changed" content="2017-08-11T04:37:37" />
    <meta name="_TemplateID" content="TC010184701033" />

    <style type="text/css">
        body,
        div,
        table,
        thead,
        tbody,
        tfoot,
        tr,
        th,
        td,
        p {
            font-family: "Arial";
            font-size: x-small
        }

        a.comment-indicator:hover+comment {
            background: #ffd;
            position: absolute;
            display: block;
            border: 1px solid black;
            padding: 0.5em;
        }

        a.comment-indicator {
            background: red;
            display: inline-block;
            border: 1px solid black;
            width: 0.5em;
            height: 0.5em;
        }

        comment {
            display: none;
        }

    </style>

</head>

<body>
    <table cellspacing="0" border="0">

        <colgroup width="35"></colgroup>
        <colgroup width="163"></colgroup>
        <colgroup width="189"></colgroup>
        <colgroup width="76"></colgroup>
        <colgroup width="106"></colgroup>
        <colgroup width="110"></colgroup>
        <colgroup span="11" width="68"></colgroup>
        <tr>
            <td height="94" align="left" valign=middle><br></td>
            <td align="left" valign=middle><b>
                    <font size=5><br><img src="{{ $logo }}" width=162 height=52 hspace=0 vspace=21>
                    </font>
                </b></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="right">
                <font face="Arial Black" size=6 color="#0066CC"><b>Dr.Dentix</b></font>
            </td>
            </td>
        </tr>
        <tr>
            <td height="17" align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
            <td align="right"><b>Fecha: </b></td>
            <td align="left" sdval="44501" sdnum="1033;1033;MMMM D\, YYYY;@">{{ $data->day }}</td>
        </tr>
        <tr>
            <td height="17" align="left"><br></td>
            <td align="left"><b>Dirección</b> {{ $data->dbraches->address }}</td>
            <td align="left"><br></td>
            <td align="left"><br></td>
            <td align="right"><b>Odontólogo: </b></td>
            <td align="left" sdval="100" sdnum="1033;">{{ $data->denpro->dentists->name }}</td>
        </tr>
        <tr>
            <td height="17" align="left" valign=top><br></td>
            <td align="left"><b>Ciudad:</b> {{ $data->dbraches->city }}</td>
            <td align="left" valign=top><br></td>
            <td align="right" valign=top><b><br></b></td>
            <td align="right" valign=top><b><br></b></td>
            <td align="right" valign=top><i><br></i></td>
        </tr>
        <tr>
            <td height="17" align="left"><br></td>
            <td align="left"><b>NIT:</b> 1118257604-1<br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
        </tr>
        <tr>
            <td colspan=6 rowspan=2 height="34" align="left"><br><img src="{{ $hr }}" width=677 height=6
                    hspace=3 vspace=14>
            </td>
        </tr>
        <tr>
        </tr>
        <tr>
            <td colspan=3 height="17" align="left"><b>
                    <font color="#0066CC"><b>Cobrado a:</b></font>
                </b></td>
            <td colspan=3 align="left"><b>
                    <font color="#0066CC">Enviado a:</font>
                </b></td>
        </tr>
        <tr>
            <td colspan=2 height="17" align="left"><b>Name:</b> {{ $data['dPacient']['name'] }}</td>
            <td align="left"><br></td>
            <td colspan=2 align="left"><b>Name:</b> Dr. Dentix</td>
            <td align="left"><br></td>
        </tr>
        {{-- <tr>
            <td colspan=2 height="17" align="left">Company Name</td>
            <td align="left"><br></td>
            <td align="left">Compañía:</td>
            <td align="left">Dr.Dentix<br></td>
            <td align="left"><br></td>
        </tr> --}}
        <tr>
            <td colspan=2 height="17" align="left"><b>C.C. </b> {{ $data->dPacient->user->document }} </td>
            <td align="left"><br></td>
            <td align="left"><b>Dirección:</b></td>
            <td align="left">{{ $data->dbraches->name }}<br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
        </tr>
        <tr>
            <td colspan=2 height="17" align="left"><b>Ciudad: </b> {{ $data->dPacient->city }}</td>
            <td align="left"><br></td>
            <td align="left"><b>Ciudad: </b> {{ $data->dbraches->city }}</td>
            <td align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
        </tr>
        <tr>
            <td colspan=2 height="17" align="left"><b>Teléfono:</b> {{ $data->dPacient->telephone }}</td>
            <td align="left"><br></td>
            <td colspan=2 align="left"><b>Teléfono:</b> {{ $data->dbraches->contact }}</td>
            <td align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
        </tr>
        <tr>
            <td height="17" align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
        </tr>
        <tr>
            <td style="border-top: 1px solid #bcbcbc; border-bottom: 1px solid #bcbcbc; border-left: 1px solid #bcbcbc; border-right: 1px solid #bcbcbc"
                height="27" align="left" valign=middle bgcolor="#FFFFFF"><b>
                    <font size=1>ID</font>
                </b></td>
            <td style="border-top: 1px solid #bcbcbc; border-bottom: 1px solid #bcbcbc; border-left: 1px solid #bcbcbc"
                colspan=2 align="left" valign=middle bgcolor="#FFFFFF"><b>
                    <font size=1 color="#333333">DESCRIPCIÓN</font>
                </b></td>
            <td style="border-top: 1px solid #bcbcbc; border-bottom: 1px solid #bcbcbc; border-left: 1px solid #bcbcbc; border-right: 1px solid #bcbcbc"
                align="left" valign=middle bgcolor="#FFFFFF"><b>
                    <font size=1 color="#333333">CANTIDAD</font>
                </b></td>
            <td style="border-top: 1px solid #bcbcbc; border-bottom: 1px solid #bcbcbc; border-left: 1px solid #bcbcbc; border-right: 1px solid #bcbcbc"
                align="left" valign=middle bgcolor="#FFFFFF"><b>
                    <font size=1 color="#333333">PRECIO UNITARIO</font>
                </b></td>
            <td style="border-top: 1px solid #bcbcbc; border-bottom: 1px solid #bcbcbc; border-left: 1px solid #bcbcbc; border-right: 1px solid #bcbcbc"
                align="left" valign=middle bgcolor="#FFFFFF"><b>
                    <font size=1 color="#333333">PRECIO TOTAL</font>
                </b></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
        </tr>

        @if (sizeof($data['facturas']) == 0)
            <tr>
                <td style="border-top: 1px solid #bcbcbc; border-bottom: 1px solid #bcbcbc; border-left: 1px solid #bcbcbc; border-right: 1px solid #bcbcbc"
                    height="27" align="right" valign=middle sdval="6" sdnum="1033;">{{ $data->id }}</td>
                <td style="border-top: 1px solid #bcbcbc; border-bottom: 1px solid #bcbcbc; border-left: 1px solid #bcbcbc"
                    align="left" valign=middle>{{ $data->denpro['procedures']['name'] }}</td>
                <td style="border-top: 1px solid #bcbcbc; border-bottom: 1px solid #bcbcbc" align="left" valign=middle>
                    <br></td>
                <td style="border-top: 1px solid #bcbcbc; border-bottom: 1px solid #bcbcbc; border-left: 1px solid #bcbcbc; border-right: 1px solid #bcbcbc"
                    align="right" valign=middle sdval="1" sdnum="1033;">1</td>
                <td style="border-top: 1px solid #bcbcbc; border-bottom: 1px solid #bcbcbc; border-right: 1px solid #bcbcbc"
                    align="right" valign=middle sdval="9.19" sdnum="1033;">${{ $data->pay }} COP</td>
                <td style="border-top: 1px solid #bcbcbc; border-bottom: 1px solid #bcbcbc; border-left: 1px solid #bcbcbc; border-right: 1px solid #bcbcbc"
                    align="right" valign=middle sdval="9.19" sdnum="1033;1033;#,##0.00_);(#,##0.00)">
                    ${{ $data->pay }} COP </td>
                <td align="left" valign=middle><br></td>
                <td align="left" valign=middle><br></td>
                <td align="left" valign=middle><br></td>
                <td align="left" valign=middle><br></td>
                <td align="left" valign=middle><br></td>
                <td align="left" valign=middle><br></td>
                <td align="left" valign=middle><br></td>
                <td align="left" valign=middle><br></td>
                <td align="left" valign=middle><br></td>
                <td align="left" valign=middle><br></td>
                <td align="left" valign=middle><br></td>
            </tr>
        @else
            @foreach ($data['facturas'] as $key)
                <tr>
                    <td style="border-top: 1px solid #bcbcbc; border-bottom: 1px solid #bcbcbc; border-left: 1px solid #bcbcbc; border-right: 1px solid #bcbcbc"
                        height="27" align="right" valign=middle sdval="6" sdnum="1033;">{{ $data->id }}</td>
                    <td style="border-top: 1px solid #bcbcbc; border-bottom: 1px solid #bcbcbc; border-left: 1px solid #bcbcbc"
                        align="left" valign=middle>{{ $key->procedure->name }}</td>
                    <td style="border-top: 1px solid #bcbcbc; border-bottom: 1px solid #bcbcbc" align="left"
                        valign=middle><br></td>
                    <td style="border-top: 1px solid #bcbcbc; border-bottom: 1px solid #bcbcbc; border-left: 1px solid #bcbcbc; border-right: 1px solid #bcbcbc"
                        align="right" valign=middle sdval="1" sdnum="1033;">1</td>
                    <td style="border-top: 1px solid #bcbcbc; border-bottom: 1px solid #bcbcbc; border-right: 1px solid #bcbcbc"
                        align="right" valign=middle sdval="9.19" sdnum="1033;">${{ $key->price }} COP</td>
                    <td style="border-top: 1px solid #bcbcbc; border-bottom: 1px solid #bcbcbc; border-left: 1px solid #bcbcbc; border-right: 1px solid #bcbcbc"
                        align="right" valign=middle sdval="9.19" sdnum="1033;1033;#,##0.00_);(#,##0.00)">
                        ${{ $key->price }} COP </td>
                    <td align="left" valign=middle><br></td>
                    <td align="left" valign=middle><br></td>
                    <td align="left" valign=middle><br></td>
                    <td align="left" valign=middle><br></td>
                    <td align="left" valign=middle><br></td>
                    <td align="left" valign=middle><br></td>
                    <td align="left" valign=middle><br></td>
                    <td align="left" valign=middle><br></td>
                    <td align="left" valign=middle><br></td>
                    <td align="left" valign=middle><br></td>
                    <td align="left" valign=middle><br></td>
                </tr>
            @endforeach
        @endif

        {{-- <tr>
            <td style="border-top: 1px solid #bcbcbc; border-bottom: 1px solid #bcbcbc; border-left: 1px solid #bcbcbc; border-right: 1px solid #bcbcbc" height="27" align="right" valign=middle sdval="7" sdnum="1033;">7</td>
            <td style="border-top: 1px solid #bcbcbc; border-bottom: 1px solid #bcbcbc; border-left: 1px solid #bcbcbc" align="left" valign=middle>Product description</td>
            <td style="border-top: 1px solid #bcbcbc; border-bottom: 1px solid #bcbcbc" align="left" valign=middle><br></td>
            <td style="border-top: 1px solid #bcbcbc; border-bottom: 1px solid #bcbcbc; border-left: 1px solid #bcbcbc; border-right: 1px solid #bcbcbc" align="right" valign=middle sdval="2" sdnum="1033;">2</td>
            <td style="border-top: 1px solid #bcbcbc; border-bottom: 1px solid #bcbcbc; border-right: 1px solid #bcbcbc" align="right" valign=middle sdval="4.29" sdnum="1033;">4.29</td>
            <td style="border-top: 1px solid #bcbcbc; border-bottom: 1px solid #bcbcbc; border-left: 1px solid #bcbcbc; border-right: 1px solid #bcbcbc" align="right" valign=middle sdval="8.58" sdnum="1033;1033;#,##0.00_);(#,##0.00)">8.58 </td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
        </tr> --}}
        <tr>
            <td height="27" align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td style="border-top: 1px solid #bcbcbc; border-left: 1px solid #bcbcbc; border-right: 1px solid #bcbcbc"
                align="left" valign=middle
                sdnum="1033;0;_(&quot;$&quot;* #,##0.00_);_(&quot;$&quot;* \(#,##0.00\);_(&quot;$&quot;* &quot;-&quot;??_);_(@_)">
                <br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
        </tr>
        <tr>
            <td height="27" align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td style="border-top: 1px solid #bcbcbc; border-bottom: 1px solid #bcbcbc" align="left" valign=middle
                sdnum="1033;1033;#,##0.00_);(#,##0.00)"><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
        </tr>
        {{-- <tr>
            <td height="27" align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td style="border-right: 1px solid #bcbcbc" colspan=3 align="right" valign=middle sdnum="1033;0;@  "><b>SUBTOTAL  </b></td>
            <td style="border-top: 1px solid #bcbcbc; border-bottom: 1px solid #dcdcdc; border-left: 1px solid #bcbcbc; border-right: 1px solid #bcbcbc" align="right" valign=middle bgcolor="#FFFFFF" sdval="2375.5" sdnum="1033;0;_(&quot;$&quot;* #,##0.00_);_(&quot;$&quot;* \(#,##0.00\);_(&quot;$&quot;* &quot;-&quot;??_);_(@_)"><b> ${{$data->pay}} COP </b></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
        </tr> --}}
        {{-- <tr>
            <td height="27" align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td style="border-right: 1px solid #bcbcbc" colspan=3 align="right" valign=middle sdnum="1033;0;@  "><b>TAX RATE PRODUCTS  </b></td>
            <td style="border-top: 1px solid #bcbcbc; border-left: 1px solid #bcbcbc; border-right: 1px solid #bcbcbc" align="right" valign=middle sdval="0.0625" sdnum="1033;0;0.00%">6.25%</td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
        </tr>
        <tr>
            <td height="27" align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td style="border-right: 1px solid #bcbcbc" colspan=3 align="right" valign=middle><b>TAX RATE SERVICES</b></td>
            <td style="border-top: 1px solid #bcbcbc; border-bottom: 1px solid #bcbcbc; border-left: 1px solid #bcbcbc; border-right: 1px solid #bcbcbc" align="right" valign=middle sdval="0.0785" sdnum="1033;0;0.00%">7.85%</td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
        </tr>
        <tr>
            <td height="27" align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td style="border-right: 1px solid #bcbcbc" colspan=3 align="right" valign=middle><b>SHIPPING AND HANDLING</b></td>
            <td style="border-top: 1px solid #bcbcbc; border-bottom: 1px solid #bcbcbc; border-left: 1px solid #bcbcbc; border-right: 1px solid #bcbcbc" align="right" valign=middle sdval="89.99" sdnum="1033;">89.99</td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
        </tr> --}}
        <tr>
            <td height="27" align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td style="border-right: 1px solid #bcbcbc" colspan=3 align="right" valign=middle><b>TOTAL</b></td>
            <td style="border-bottom: 1px solid #dcdcdc; border-left: 1px solid #bcbcbc; border-right: 1px solid #bcbcbc"
                align="right" valign=middle bgcolor="#FFFFFF" sdval="2628.60995"
                sdnum="1033;0;_(&quot;$&quot;* #,##0.00_);_(&quot;$&quot;* \(#,##0.00\);_(&quot;$&quot;* &quot;-&quot;??_);_(@_)">
                <b> ${{ $data->pay }} COP</b></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
            <td align="left" valign=middle><br></td>
        </tr>
    </table>
    <!-- ************************************************************************** -->
    <br><br><br><br><br><br><br><br><br>
</body>

</html>
