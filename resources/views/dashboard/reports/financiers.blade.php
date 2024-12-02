<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8" />
    <title>تقرير الممولين</title>
    <style>
        body {
            font-family: 'XBRiyaz', sans-serif;
        }

        @page {
            header: page-header;
            footer: page-footer;
        }
    </style>
    <style>
        table.blueTable {
            width: 100%;
            text-align: right;
            border-collapse: collapse;
        }

        table.blueTable td,
        table.blueTable th {
            border: 1px solid #AAAAAA;
            padding: 5px 9px;
            white-space: nowrap;
        }

        table.blueTable tbody td {
            font-size: 13px;
            color: #000000;
        }

        table.blueTable tbody tr:nth-child(even) {
            background: #F5F5F5;
        }

        table.blueTable thead {
            background: #b8b8b8;
            background: -moz-linear-gradient(top, #dedede 0%, #d7d7d7 66%, #D3D3D3 100%);
            background: -webkit-linear-gradient(top, #dedede 0%, #d7d7d7 66%, #D3D3D3 100%);
            background: linear-gradient(to bottom, #dedede 0%, #d7d7d7 66%, #D3D3D3 100%);
            border-bottom: 2px solid #444444;
        }

        table.blueTable thead th {
            font-size: 18px;
            font-weight: bold;
            text-align: right;
        }

        table.blueTable tfoot {
            font-size: 14px;
            font-weight: bold;
            color: #FFFFFF;
            background: #EEEEEE;
            background: -moz-linear-gradient(top, #f2f2f2 0%, #efefef 66%, #EEEEEE 100%);
            background: -webkit-linear-gradient(top, #f2f2f2 0%, #efefef 66%, #EEEEEE 100%);
            background: linear-gradient(to bottom, #f2f2f2 0%, #efefef 66%, #EEEEEE 100%);
            border-top: 2px solid #444444;
        }

        table.blueTable tfoot td {
            font-size: 14px;
        }

        table.blueTable tfoot .links {
            text-align: right;
        }

        table.blueTable tfoot .links a {
            display: inline-block;
            background: #1C6EA4;
            color: #FFFFFF;
            padding: 2px 8px;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <htmlpageheader name="page-header">
    </htmlpageheader>

    <div lang="ar">
        <table class="blueTable">
            <thead>
                <tr>
                    <td colspan="12" style="border:0;">
                        <p>
                            <span>مستشفى يافا الطبي</span> /
                            <span>مشروع إجراء عمليات جراحية وتدخلات طبية</span>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td colspan="11" align="center" style="color: #000;border:0; margin-bottom: 20px;">
                        <h1>تقرير الممولين</h1>
                    </td>
                </tr>
                <tr style="background: #dddddd;">
                    <th>#</th>
                    <th>رقم الممول</th>
                    <th>الاسم</th>
                    <th>المرحلة</th>
                    <th>اسم المدير</th>
                    <th>الملبع ش</th>
                    <th>عدد الحالات</th>
                    <th  style="text-align: center;">إنتهاء <br> المشروع</th>
                    <th  style="text-align: center;">دفع <br> المشروع</th>
                    <th  style="text-align: center;">توزيع <br> المشروع</th>
                    <th  style="text-align: center;">أرشفة <br> المشروع</th>
                </tr>
            </thead>
            <tbody>
                @foreach($financiers as $financier)
                    <tr >
                        <td>{{$loop->iteration}}</td>
                        <td>{{$financier->financier_number}}</td>
                        <td>{{$financier->name}}</td>
                        <td>{{$financier->stage}}</td>
                        <td>{{$financier->manager_name}}</td>
                        <td>{{$financier->amount_ils}}</td>
                        <td  style="text-align: center;">{{$financier->number_cases}}</td>
                        <td style="text-align: center;">
                            @if ($financier->completion_project == 1)
                                <p style="font-family: Helvetica, Arial, Sans-Serif; font-size: 16px;">&#9745;</p>
                            @endif
                        </td>
                        <td style="text-align: center;">
                            @if ($financier->push_project == 1)
                                <p style="font-family: Helvetica, Arial, Sans-Serif; font-size: 16px;">&#9745;</p>
                            @endif
                        </td>
                        <td style="text-align: center;">
                            @if ($financier->project_distribution == 1)
                                <p style="font-family: Helvetica, Arial, Sans-Serif; font-size: 16px;">&#9745;</p>
                            @endif
                        </td>
                        <td style="text-align: center;">
                            @if ($financier->project_archive == 1)
                                <p style="font-family: Helvetica, Arial, Sans-Serif; font-size: 16px;">&#9745;</p>
                            @endif
                        </td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
        <htmlpagefooter name="page-footer">
            <table width="100%" style="vertical-align: bottom; color: #000000;  margin: 1em">
                <tr>
                    <td width="33%">{DATE j-m-Y}</td>
                    <td width="33%" align="center">{PAGENO}/{nbpg}</td>
                    @auth
                        <td width="33%" style="text-align: left;">{{ Auth::user()->name }}</td>
                    @else
                        <td width="33%" style="text-align: left;">اسم المستخدم</td>
                    @endauth
                </tr>
            </table>
        </htmlpagefooter>
    </div>


</body>

</html>
