<?php

namespace App\Http\Controllers;

use App\client;
use App\investor;
use Illuminate\Http\Request;
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
                return $this->clientReport($request, $request->type_report_t);
            } else {
                return $this->clientReport($request, $request->type_report_t);
            }
        } else {
            if ($request->type_report_t == 1) {
                return $this->investorReport($request, $request->type_report_t);
            } else {
                return $this->investorReport($request, $request->type_report_t);
            }
        }
    }

    public function clientReport($request, $type_report_t)
    {
        $clients = client::where('state','1')->with('sales.vehicle.payments')->get();
        return $clients;
    }

    public function investorReport($request, $type_report_t)
    {
        $investor = [];
        $vehicles = array();
        $total = 0;
        $counter = 0;
        $payments = investor::where('investors.id',$request->investor_id)
        ->whereBetween('payments.created_at', [$request->dateinit.' 00:00:00', $request->dateend.' 23:59:59'])
        ->join('vehicles', 'vehicles.investor_id', '=', 'investors.id')
        ->join('sales', 'sales.vehicle_id', '=', 'vehicles.id')
        ->join('users', 'users.id', '=', 'investors.user_id')
        ->join('payments', 'payments.sale_id', '=', 'sales.id')->get();

        for ($i=0; $i < $payments->count(); $i++) {
            if ($payments[$i]->type == 'pago') {
                if ($i > 0) {
                    foreach ($vehicles as $v) {
                        if ($v['placa'] == $payments[$i]->placa) {
                            $v['total'] += $payments[$i]->amount;
                            break;
                        } else {
                            $vehicle = array('placa'=>$payments[$i]->placa, 'total'=>$payments[$i]->amount);
                            print_r($vehicles);
                            array_push($vehicles, $vehicle);
                            break;
                        }

                    }
                } else {

                }
            }
        }

        return ;
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
