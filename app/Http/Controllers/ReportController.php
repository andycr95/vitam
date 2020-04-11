<?php

namespace App\Http\Controllers;

use App\client;
use App\investor;
use App\payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade as PDF;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        return view('pages.reports.reports');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function routesReport(Request $request)
    { 
        if ($request->type_report_c_i == 1) {
            if ($request->type_report_t == 1) {
                if (Auth::user()->employee == null) {
                    return $this->clientReportD($request, $request->type_report_t);
                } else {
                    return $this->clientReportDB($request, $request->type_report_t);
                }
                
            } elseif($request->type_report_t == 2) {
                return $this->clientReportW($request, $request->type_report_t);
            } elseif($request->type_report_t == 3) {
                return $this->clientReportM($request, $request->type_report_t);
            }
        } else {
            return $this->investorReport($request, $request->type_report_t);
        }
    }

    public function clientReportW($request, $type_report_t)
    {
        setlocale(LC_TIME, 'es_ES.UTF-8');
        $dateinit = $request->dateinit." 00:00:00";
        $dateend = $request->dateend." 23:59:59";
        $clients = DB::select('select clients.name, clients.last_name, sales.id as sale_id, clients.id as client_id, SUM(payments.amount) as Total, vehicles.id as vehicle_id, vehicles.investor_id from clients join sales on sales.client_id=clients.id join payments on payments.sale_id=sales.id join vehicles on vehicles.id=sales.vehicle_id where payments.created_at BETWEEN ? AND ? GROUP BY sales.id', [$dateinit, $dateend]);
        $total= 0;
        $totalv= 0;
        $date = strftime("%d de %B del %Y", strtotime(date("r")));
        for ($i=0; $i < count($clients); $i++) { 
            DB::statement('SET lc_time_names = "es_CO"');
            $py = DB::select('select  DATE_FORMAT(created_at, "%d %M") as cr from payments where type="pago" and sale_id= ? order by created_at desc limit 1;', [$clients[$i]->sale_id]);
            $clients[$i]->date_end = $py[0]->cr;
            if ($clients[$i]->investor_id == 1) {
                $totalv += $clients[$i]->Total;
            }
            $total += $clients[$i]->Total;
            $clients[$i]->Total = "$ ".number_format($clients[$i]->Total);
        }
        $tv = "$ ".number_format($totalv);
        $t = "$ ".number_format($total);
        $name = "Reporte".strftime("%d de %B del %Y", strtotime(date("r")));
        $pdf = PDF::loadView('pdf.client-report', compact('clients','name', 't', 'tv', 'date'));
        return $pdf->download($name.'.pdf');
    }

    public function clientReportM($request, $type_report_t)
    {
        setlocale(LC_TIME, 'es_ES.UTF-8');
        $clients = DB::select('select clients.name, clients.last_name, sales.id as sale_id, clients.id as client_id, SUM(payments.amount) as Total, vehicles.id as vehicle_id, vehicles.investor_id from clients join sales on sales.client_id=clients.id join payments on payments.sale_id=sales.id join vehicles on vehicles.id=sales.vehicle_id where MONTH(payments.created_at) = ? GROUP BY sales.id', [$request->month]);
        $total= 0;
        $totalv= 0;
        $date = strftime("%d de %B del %Y", strtotime(date("r")));
        for ($i=0; $i < count($clients); $i++) { 
            DB::statement('SET lc_time_names = "es_CO"');
            $py = DB::select('select  DATE_FORMAT(created_at, "%d %M") as cr from payments where type="pago" and sale_id= ? order by created_at desc limit 1;', [$clients[$i]->sale_id]);
            $clients[$i]->date_end = $py[0]->cr;
            if ($clients[$i]->investor_id == 1) {
                $totalv += $clients[$i]->Total;
            }
            $total += $clients[$i]->Total;
            $clients[$i]->Total = "$ ".number_format($clients[$i]->Total);
        }
        $tv = "$ ".number_format($totalv);
        $t = "$ ".number_format($total);
        $name = "Reporte".strftime("%d de %B del %Y", strtotime(date("r")));
        $pdf = PDF::loadView('pdf.client-reportM', compact('clients','name', 't', 'tv', 'date'));
        return $pdf->download($name.'.pdf');
    }

    public function clientReportD($request, $type_report_t)
    {
        setlocale(LC_TIME, 'es_ES.UTF-8');
        $day = $request->day.' 00:00:00';
        $lday = $request->day.' 23:59:59';
        $clients = DB::select('select clients.name, clients.last_name, sales.id as sale_id, clients.id as client_id, SUM(payments.amount) as Total, vehicles.id as vehicle_id, vehicles.investor_id from clients join sales on sales.client_id=clients.id join payments on payments.sale_id=sales.id join vehicles on vehicles.id=sales.vehicle_id where payments.created_at BETWEEN ? AND ? GROUP BY sales.id;', [$day, $lday]);
        $total= 0;
        $totalv= 0;
        $date = strftime("%d de %B del %Y", strtotime(date("r")));
        for ($i=0; $i < count($clients); $i++) { 
            DB::statement('SET lc_time_names = "es_CO"');
            $py = DB::select('select  DATE_FORMAT(created_at, "%d %M") as cr from payments where sale_id=? and created_at BETWEEN ? AND ? order by created_at desc limit 1;', [$clients[$i]->sale_id, $day, $lday]);
            $clients[$i]->date_end = $py[0]->cr;
            if ($clients[$i]->investor_id == 1) {
                $totalv += $clients[$i]->Total;
            }
            $total += $clients[$i]->Total;
            $clients[$i]->Total = "$ ".number_format($clients[$i]->Total);
        }
        $tv = "$ ".number_format($totalv);
        $t = "$ ".number_format($total);
        $name = "Reporte".strftime("%d de %B del %Y", strtotime(date("r")));
        $pdf = PDF::loadView('pdf.client-reportD', compact('clients','name', 't', 'tv', 'date'));
        return $pdf->download($name.'.pdf');
    }
    
    public function clientReportDB($request, $type_report_t)
    {
        setlocale(LC_TIME, 'es_ES.UTF-8');
        $day = $request->day." 00:00:00";
        $auth = Auth::user()->employee->branchoffice_id;
        $lday = $request->day." 23:59:59";
        $clients = DB::select('select clients.name, vehicles.branchoffice_id, clients.last_name, sales.id as sale_id, clients.id as client_id, SUM(payments.amount) as Total, vehicles.id as vehicle_id, vehicles.investor_id from clients join sales on sales.client_id=clients.id join payments on payments.sale_id=sales.id join vehicles on vehicles.id=sales.vehicle_id where vehicles.branchoffice_id = ? AND  payments.created_at BETWEEN ? AND ? GROUP BY sales.id', [$day, $lday, $auth]);
        $total= 0;
        $totalv= 0;
        $date = strftime("%d de %B del %Y", strtotime(date("r")));
        for ($i=0; $i < count($clients); $i++) { 
            DB::statement('SET lc_time_names = "es_CO"');
            $py = DB::select('select  DATE_FORMAT(created_at, "%d %M") as cr from payments where sale_id=? and created_at BETWEEN ? AND ? order by created_at desc limit 1;', [$clients[$i]->sale_id, $day, $lday]);
            $clients[$i]->date_end = $py[0]->cr;
            if ($clients[$i]->investor_id == 1) {
                $totalv += $clients[$i]->Total;
            }
            $total += $clients[$i]->Total;
            $clients[$i]->Total = "$ ".number_format($clients[$i]->Total);
        }
        $tv = "$ ".number_format($totalv);
        $t = "$ ".number_format($total);
        $name = "Reporte".strftime("%d de %B del %Y", strtotime(date("r")));
        $pdf = PDF::loadView('pdf.client-reportD', compact('clients','name', 't', 'tv', 'date'));
        return $pdf->download($name.'.pdf');
    }

    public function investorReport($request, $type_report_t)
    {
        setlocale(LC_TIME, 'es_ES.UTF-8');
        $vehicles = DB::select('select vehicles.placa as placa, investors.type as investor_type, sales.vehicle_id as vehicle_id, investors.id as investor_id, SUM(payments.amount) as payment from investors join vehicles on vehicles.investor_id=investors.id join sales on sales.vehicle_id=vehicles.id join clients on clients.id=sales.client_id join payments on payments.sale_id=sales.id where investors.id=? AND MONTH(payments.created_at) =? GROUP BY payments.sale_id', [$request->investor_id, $request->month]);
        $name = "Reporte".date("r");
        $investor = investor::find($request->investor_id);
        $total= 0;
        $date = strftime("%d de %B del %Y", strtotime(date("r")));
        $month = strftime("%B", strtotime(date("r")));
        $totalp= 0;
        $totala= 0;
        for ($i=0; $i < count($vehicles); $i++) {
            $total += $vehicles[$i]->payment;
            if ($vehicles[$i]->investor_type == 1) {
                $vehicles[$i]->pasive = ($vehicles[$i]->payment * 0.12);
                $vehicles[$i]->active = ($vehicles[$i]->payment - $vehicles[$i]->pasive);
            } elseif ($vehicles[$i]->investor_type == 2) {
                $vehicles[$i]->pasive = ($vehicles[$i]->payment * 0.1);
                $vehicles[$i]->active = ($vehicles[$i]->payment - $vehicles[$i]->pasive);
            } elseif ($vehicles[$i]->investor_type == 3) {
                $vehicles[$i]->pasive = ($vehicles[$i]->payment * 0.15);
                $vehicles[$i]->active = ($vehicles[$i]->payment - $vehicles[$i]->pasive);
            }
            $vehicles[$i]->payment = "$ ".number_format($vehicles[$i]->payment);
            $totala += $vehicles[$i]->active;
            $totalp += $vehicles[$i]->pasive;
            $vehicles[$i]->pasive = "$ ".number_format($vehicles[$i]->pasive);
            $vehicles[$i]->active = "$ ".number_format($vehicles[$i]->active);
        }

        $t = "$ ".number_format($total);
        $tp = "$ ".number_format($totalp);
        $ta = "$ ".number_format($totala);
        $pdf = PDF::loadView('pdf.investor-report', compact('vehicles','name', 'date', 't','tp', 'ta', 'investor', 'month'));
        return $pdf->download($name.'.pdf');
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\report  $report
     * @return \Illuminate\Http\Response
     */
    public function show(report $report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\report  $report
     * @return \Illuminate\Http\Response
     */
    public function edit(report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\report  $report
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy(report $report)
    {
        //
    }
}