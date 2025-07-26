<?php

namespace App\Http\Controllers\API\CRM;

use App\Http\Controllers\Controller;
use App\Models\Quote;
use App\Models\Cpu;
use App\Models\Raid;
use App\Models\RamCpu;
use App\Models\Ram;
use App\Models\Price;
use App\Models\Disk;
use App\Models\User;
use App\Models\Addon;
use App\Models\Cloud;
use App\Models\Title;
use App\Models\Service;
use App\Models\Transfer;
use App\Models\AddonTypes;
use App\Models\DataCenter;
use App\Models\PublicPort;
use App\Models\TypeService;
use App\Models\ControlPanel;
use App\Models\PaymentCycle;
use App\Models\Administration;
use App\Models\Cost;
use App\Models\ServiceFeature;
use App\Models\OperativeSystem;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class QuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       // return redirect()->route('pdf_quotes',$request);

       return response()->json( json_decode($request->getContent())[0] );
       return response()->json([
           'data' => $request->getContent(),
           'success' => true,
           'message' => $request->input('vpsList'),
       ]);


       //return  print_r($request);
       // print_r($request['vpsList']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Quote $quote)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quote $quote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quote $quote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quote $quote)
    {
        //
    }

    /**
     * Retrieve Quotes with query arguments
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $q
     * @param  int  $perPage
     * @param  int  $currentPage
     * @return \Illuminate\Http\JsonResponse
     */
    public function query(Request $request): JsonResponse
    {
        $success = false;
        $message = '';

        $skip = $request->currentPage ? ($request->currentPage - 1) * $request->perPage : 0;
        $perPage = $request->perPage ? $request->perPage : 10;
        $totalPage = 0;
        $totalResults = 0;

        $select = [
            'quotes.id',
            'quotes.collaborator_id',
            'quotes.quote_catalog_id',
            'quotes.content',
            'quotes.created_at',
            'quotes.updated_at',
            'collaborators.email AS collaborator',
            'quote_catalogs.label as flow',
            'quote_catalogs.color'
        ];

        $query = Quote::select($select)
            ->leftJoin('collaborators', 'collaborators.id', 'quotes.collaborator_id')
            ->leftJoin('quote_catalogs', 'quote_catalogs.id', 'quotes.quote_catalog_id');

        if ($request->has('sortBy')) {
            if ($request->sortBy) {
                foreach ($request->sortBy as $groupBy) {
                    $query->orderBy($groupBy['key'], $groupBy['order']);
                }
            } else {
                $query->orderBy('quotes.id', 'DESC');
            }
        } else {
            $query->orderBy('quotes.id', 'DESC');
        }

        if ($request->has('q')) {
            if ($request->q) {
                $query->where('collaborator_id', 'like', '%' . $request->q . '%')
                    ->orWhere('quote_catalog_id', 'like', '%' . $request->q . '%');
            }
        }

        $totalResults = $query->count();

        if ($perPage > -1) {
            $query->skip($skip)->take($perPage);
        }

        $filteredResults = $query->get();

        if ($filteredResults) {
            $totalPage = ceil($totalResults / $perPage) ? ceil($totalResults / $perPage) : 1;

            $success = true;
            $message = 'Quotes fetched correctly';
        }

        return response()->json([
            'data' => $filteredResults,
            'totalPage' => $totalPage,
            'totalResults' => $totalResults,
            'success' => $success,
            'message' => $message,
        ]);
    }//public function query(Request $request): JsonResponse ..



    public function getCpuDetails($id)
    {
        $idCPU = $id;
        $rams = RamCpu::where('ram_cpus.id_cpu', '=', $idCPU)
            ->leftJoin('rams', 'rams.id', '=', 'ram_cpus.id_ram')
            ->select('rams.id', 'rams.name')
            ->get()
            ;
        $details = CPU::where('cpus.id', '=', $idCPU)
            ->leftJoin('ram_cpus', function ($join) {
                $join->on('ram_cpus.id_cpu', '=', 'cpus.id');
            })
            ->where('ram_cpus.price', '=', 0)
            ->select('id_disk_1', 'id_disk_2', 'id_public_port', 'id_transfer', 'id_ram')->get()->toArray();
        if (!empty($rams) && !empty($details)) {
            $response = array('rams' => $rams, 'details' => $details);
            return response()->json($response);
        } else
            return response()->json(array('errors' => array('Sin Rams')));
    }



    public function getRaidDetails($id)
    {
        $raid = Raid::where('id', '=', $id)->select('min', 'max')->get();
        if (!$raid) {
            return response()->json(array('errors' => array($this->messageObj . 'no encontrado(a)')));
        } else {
            return response()->json($raid);
            //return response()->json($raid->toArray());
        }
    }


    public function getRaidSpecs($id)
    {
/*
        if ($id == null) {
            $raids = Raid::
            select('raid.id', 'raid.name')
            ->get();
            if (!empty($raids))
                return response()->json($raids);
            else
                return response()->json(array('errors' => array('Sin Raids')));
        } else {*
            $raid = Raid::where('id_raid', '=', $id)->select('min_raid', 'max_raid')->get();
            if (!$raid) {
                return response()->json(array('errors' => array($this->messageObj . 'no encontrado(a)')));
            } else {
                return response()->json($raid->toArray());
            }*/

            return print_r($id);
    }//public function getRaidSpecs($id)


        //Permitir 41 lineas, cada fila de la tabla cuenta como 1.5 lineas
        function shrinkPagesByLines(){
            $page_break = '
            </table>
            </div>
                <div style="">
                    <img style="position: absolute;  bottom: 0px; left: 0;  width: 105%; padding: 0px;" src="'. base_path() .'/public/images/pdf/footer_r.jpg">
                </div>
            </div>
        </div>
            <!-- new page  -->
            <div class="row">
                <div class="column" style="width:100%;">
                    <!-- HEADER -->
                    <div class="row">
                        <img style="width: 105%; padding: 0px;" src="'. base_path() .'/public/images/pdf/headerCot.jpg" height="200px">
                    </div>
                    <p style="text-align: right; margin-right: 32px; margin-top:10px;">Guadalajara, Jalisco, México a
                        ' . strftime('%e de %B del %Y') . ' </p>
                        <div style="margin-left: 30px; margin-right: 60px;">
                        <table class=\'services_table\' style="width:100%;"  >
                            <tr style=\'padding:3px;background-color: #FFA500;   font-weight: bold; font-size: 13px;\'>
                                <td align=\'center\'>Servicio</td>
                                <td align=\'center\'>Costo Base</td>
                                <td align=\'center\'>Panel</td>
                                <td align=\'center\'>Addons</td>
                                <td align=\'center\'>Ciclo de Pago</td>
                                <td align=\'center\'>Descuento</td>
                                <td align=\'center\'>Importe</td>
                            </tr>';

            return $page_break;
        }


    public function getPDF(Request $request)
    {   //change locale for date
        setlocale(LC_ALL, "es_ES");
       $params = json_decode($request->getContent());
//       $params = json_decode($request->getContent(), true); //Devuelve un objeto data{ datacenter: 2, ... }, sin embargo internamente este objeto es transparente y se accede directamente a las propiedades del mismo $params['datacenter']

/*
       return response()->json([
            //'data' => $params[1]->vpsList,
            'success' => true,
            'message' => $params[0]->serverList
        ]);
*/


        //$servicesList = $params[1]->vpsList;
        $servicesList = $params[0];
        $servicesWithCost = ['serverList','vpsList','placementList'];
        $services = ['serverList','vpsList','placementList'];
        $servicesCount = 0;
        $element = array();

        $body = '';
        $conditions = '';
        $lines_count = 0;
        $max_lines_per_sheet = 41;

        $totals = array(
                'service' => 0,
                'control_panel' => 0,
                'addons' => 0,
                'total' => 0
        );
        foreach ($servicesList as $serviceType => $serviceTypeElem){

            foreach($serviceTypeElem as $elem){

              //  $servicesCount++;

                if (in_array($serviceType, $servicesWithCost)) {
                    $payment = Cost::where('id', 46)->first();//$request[$service . '_payment_cost_id'])->first();
                    $paymentName = $payment['label'];
                    $paymentCharge = $payment['cost'];
                    $price = 600+rand(0,25000); //$request[$service . '_base_price']; // Services::query con esta llamada aun no probada aqui se puede obtener los datos de los precios, pero mejor enviarlos por formulario
               /*  return response()->json([
                    //'data' => $params[1]->vpsList,
                    'success' => true,
                    'message' => $payment,
                ]); */
                } else {
                    //empezar solo con los de pago normal
                /* $payment = PaymentCycle::where('charge_payment_cycle', '=', $request[$service . '_payment_cycle'])->get()->toArray();
                    $paymentName = $payment[0]['name_payment_cycle'];
                    $paymentCharge = $payment[0]['charge_payment_cycle'];
                    $price = $request[$service . '_base_price'] * $paymentCharge;*/
                }

                $cpPrice = 0;
                $subtotal = 0;
                $pricePromo = 0;
                $iva = 0;
                $cp = null;

                $finalPrice = $price *1.16;//$request[$service . '_price'];
                $discount = 0; //$request[$service . '_discount'];
                (isset($elem->datacenter)) ?
                    $dcName = DataCenter::find($elem->datacenter)->name :
                    $dcName = "";
                    $serviceName = '';

                (isset($elem->service)) ?
                    // $features = ServiceFeature::where('id_service_service_feature', '=', $request[$service . '_select'])->get() :
                    $features = ServiceFeature::where('id_service', $elem->service)->get() :
                    $features = null;

                (isset($elem->transfer)) ?
                    $transferName = Transfer::find($elem->transfer)->name_transfer :
                    $transferName = null;

                // Buscar precio de Panel de control
                if (isset($elem->controlPanel)) {
                    /*
                    Revisar porque se declara un objeto cuando debe ser un entero, tambien la tabla COST es obsoleta y deberia llamar la tabla PRICE que es la que usa el frontend y esta mas validada

                    $cpPrice = Cost::where(['id_service' => $elem->controlPanel, 'table' => 'panel', 'label' => $paymentName])->first();

                    if($cpPrice==null){
                        $cpPrice = new \stdClass();
                        $cpPrice->cost = "0.00";
                    }*/

                    $controlpanelName = ControlPanel::find($elem->controlPanel)->name;

                }

                switch ($serviceType) {
                    case 'vpsList':
                        $serviceName = Service::find($elem->service)->name;


                        //array_push($element, '<p class="details"><strong> Enterprise ' . $serviceName . '</strong></p>');
                        /*
                        if ($features !== null) {
                            foreach ($features as $feature) {
                                array_push($element, '<p class="details">' . $feature->name_service_feature . '</p>');
                            }
                        }
                      //  array_push($element, '<p class="details">Enterprise Data Center - ' . $dcName . '</p>');
                        if ($cpPrice == 0) {
                            array_push($element, '<p class="details">Panel de control: ' . $cp . '</p>');
                        }*/
                        break;
                        default:
                        break;
                } // SWITCH END Services


               /*   return response()->json([
                    //'data' => $params[1]->vpsList,
                    'success' => true,
                    'message' => $serviceName,
                ]);
 */

            // Addons
            if (isset($elem->addons_selecteds)  || $cpPrice != 0) {
                /*if ($type == 'cloud') {
                    array_push($element, '<p class="details">*Estimado ' . $paymentName . ': $' . number_format($price, 2, '.', ',') . ' MXN (IVA incluido) </p>');
                } else {*/

                    array_push($element, '<p class="details">Precio ' . $paymentName . ': $' . number_format($price, 2, '.', ',') . ' MXN (IVA incluido) </p>');
                //}
            }
            if ($cpPrice != 0) {
                $thirdpartySw = true;
                array_push($element, '<br>');
                array_push($element, '<p class="details" style="color: #F37720"><strong>Servicios Adicionales:</strong></p>');
                array_push($element, '<p class="details">' . $cp . ': &nbsp;&nbsp;&nbsp;$' . number_format($cpPrice, 2, '.', ',') . ' MXN (IVA incluido) **</p>');
            }
            $addonsPrice = 0;
            $addonscount = 0;
            $body_addons = '';
            if (isset($elem->addons_selecteds)) {
                if ($cpPrice == 0) {
                    array_push($element, '<br>');
                    array_push($element, '<p class="details" style="color: #F37720"><strong>Servicios Adicionales:</strong></p>');
                }
                foreach ($elem->addons_selecteds as $id_addon) {
                    $addonscount++;
                    $addon = Addon::find($id_addon);
                    $addon_type = AddonTypes::find($addon->type_id);

                    if (in_array($serviceType, $servicesWithCost)) {
                    //de donde sale $elem->addons_selecteds
                        $addonPrice = Cost::where(['id_service' => $request[$service . '_addon'], 'table' => 'addon', 'label' => $paymentName])->first()->cost;
                    } else {
                        $addonPrice = ($paymentCharge != 11) ? $addon->price_monthly * $paymentCharge : $addon->price_annual;
                    }

                    if (strpos($addon_type->key, 'SW_TERCEROS') !== false) {
                        $thirdpartySw = true;
                        array_push($element, '<p class="details">' . $addon->name . ':&nbsp;&nbsp;&nbsp;$' . number_format($addonPrice, 2, '.', ',') . ' MXN (IVA incluido) ** </p>');
                    } else {
                        array_push($element, '<p class="details">' . $addon->name . ':&nbsp;&nbsp;&nbsp;$' . number_format($addonPrice, 2, '.', ',') . ' MXN (IVA incluido) </p>');
                    }
                    $addonsPrice += $addonPrice;
                }
            }


            if($lines_count+2 > $max_lines_per_sheet){
                $body .= shrinkPagesByLines();
            }

            $lines_count += 1.5;

            $payment_cycle = PaymentCycle::find($elem->payment_cycle)->name;

            $body .= "<tr style='font-size:11px;'>";
            $body .= '<td align=\'center\' class=\'td_servicio\' style=\'padding:3px\'>'.strtoupper(str_replace('List', '', $serviceType)).'</td>';
            $body .= '<td align=\'right\' class=\'td_servicio\' style=\'padding:3px\'>'. $elem->service_price . '</td>';
            $body .= '<td align=\'right\' class=\'td_servicio\' style=\'padding:3px\'>'. $elem->control_panel_price . '</td>';
            $body .= '<td align=\'right\' class=\'td_servicio\' style=\'padding:3px\'>'. $elem->addons_price . '</td>';
            $body .= '<td align=\'center\' class=\'td_servicio\' style=\'padding:3px\'>'. $payment_cycle . '</td>';
            $body .= '<td align=\'right\' class=\'td_servicio\' style=\'padding:3px\'>'. $elem->discount . '</td>';
            $body .= '<td align=\'right\' class=\'td_servicio\' style=\'padding:3px\'>'. $elem->total . '</td></tr>';
            $totals['service'] += $elem->service_price;
            $totals['control_panel'] += $elem->control_panel_price;
            $totals['addons'] += $elem->addons_price;
            $totals['total'] += $elem->total;

            $conditions .= "<tr><td style='font-size:11px;' align='left'><div style='font-weight:bold'>* " .strtoupper(str_replace('List', '', $serviceType)) . "</div>";
            //$conditions .= '<div>Datacenter: '.$elem->datacenter. ' ' . $dcName.'</div>';

            if($serviceType=='serverList'){
                $cpu_name = Cpu::find($elem->cpu)->name;
                $conditions .= '<div style=\'font-weight:bold\'>'. $cpu_name . '</div>';

                $ram_name = Ram::find($elem->ram)->name;
                $conditions .= '<div>RAM: '. $ram_name . '</div>';

                if($elem->disk1!=''){
                    $disk1_name = Disk::find($elem->disk1)->name;
                    $conditions .= '<div>Disco Duro 1: '. $disk1_name . '</div>';
                }

                if($elem->disk2!=''){
                    $disk2_name = Disk::find($elem->disk2)->name;
                    $conditions .= '<div>Disco Duro 2: '. $disk2_name . '</div>';
                }

                $administration_name = Administration::find($elem->administration)->name;
                $conditions .= '<div>'. $administration_name . '</div>';

                $operative_system_name = OperativeSystem::find($elem->operativeSystem)->name;
                $conditions .= '<div>Sistema Operativo: '. $operative_system_name . '</div>';

                $control_panel_name = ControlPanel::find($elem->controlPanel)->name;
                $conditions .= '<div>Panel de Control: '. $control_panel_name . '</div>';

                $public_port_name = PublicPort::find($elem->publicPort)->name;
                $conditions .= '<div>Puerto Publico: '. $public_port_name . '</div>';

                $transfer_name = Transfer::find($elem->transfer)->name;
                $conditions .= '<div>'. $transfer_name . '</div>';
                $conditions .= '<div>1 Dirección IPv4 Dedicada (IPv6 Disponible)</div>';

                $data_center_name = DataCenter::find($elem->datacenter)->name;
                $conditions .= '<div>'. $data_center_name . '</div>';

                $conditions .= '<div>Soporte en español 24/7</div>';
                $conditions .= '<div>Servidor Escalable (Procesador, RAM, Discos, Bandwith)</div>';
                $conditions .= '<div>Acceso como usuario root (Full Access)</div>';
                $conditions .= '<div>Soporte Profesional vía chat, ticket y teléfono</div>';
                $conditions .= '<div>Auditoría de seguridad (Security Deployed)</div>';
                $conditions .= '<div>Garantía del 99.9% Mensual de Uptime</div>';
                $conditions .= '<div>Factura Fiscal del Servicio</div>';

            }

            /*foreach($features as $feature){
                $conditions .= '<small>' . $feature->name . ', </small>';
            }*/
            $conditions .= "<br></td></tr>";

            } //            foreach($serviceTypeElem as $elem..

        }


        //if($lines_count+5 > $max_lines_per_sheet){
            $body .= $this->shrinkPagesByLines();
        //}
        $lines_count += 4.5; //3 filas siguientes

        //Permitir 41 lineas
        //Totales
        $body .= "<tr style='font-size:11px;'>";
        $body .= '<td align=\'center\' class=\'td_servicio\' style=\'padding:3px; font-weight:bold\'>Subtotal</td>';
        $body .= '<td align=\'right\' class=\'td_servicio\' style=\'padding:3px\'>'. $totals['service'] . '</td>';
        $body .= '<td align=\'right\' class=\'td_servicio\' style=\'padding:3px\'>'. $totals['control_panel'] . '</td>';
        $body .= '<td align=\'right\' class=\'td_servicio\' style=\'padding:3px\'>'. $totals['addons'] . '</td>';
        $body .= '<td align=\'right\' class=\'td_servicio\' style=\'padding:3px\'></td>';
        $body .= '<td align=\'right\' class=\'td_servicio\' style=\'padding:3px\'></td>';
        $body .= '<td align=\'right\' class=\'td_servicio\' style=\'padding:3px; font-weight:bold; \'>'. $totals['total'] . '</td>';

        $body .= "<tr style='font-size:11px;'>";
        $body .= '<td align=\'center\' class=\'td_servicio\' style=\'padding:3px; font-weight:bold\'>IVA</td>';
        $body .= '<td align=\'right\' class=\'td_servicio\' style=\'padding:3px\'>'. $totals['service']*.16 . '</td>';
        $body .= '<td align=\'right\' class=\'td_servicio\' style=\'padding:3px\'>'. $totals['control_panel']*.16 . '</td>';
        $body .= '<td align=\'right\' class=\'td_servicio\' style=\'padding:3px\'>'. $totals['addons']*.16 . '</td>';
        $body .= '<td align=\'right\' class=\'td_servicio\' style=\'padding:3px\'></td>';
        $body .= '<td align=\'right\' class=\'td_servicio\' style=\'padding:3px\'></td>';
        $body .= '<td align=\'right\' class=\'td_servicio\' style=\'padding:3px; font-weight:bold; \'>'. $totals['total']*.16 . '</td>';


        $body .= "<tr style='font-size:11px;'>";
        $body .= '<td align=\'center\' class=\'td_servicio\' style=\'padding:3px; font-weight:bold; \'>Total</td>';
        $body .= '<td align=\'right\' class=\'td_servicio\' style=\'padding:3px\'>'. $totals['service']*1.16 . '</td>';
        $body .= '<td align=\'right\' class=\'td_servicio\' style=\'padding:3px\'>'. $totals['control_panel']*1.16 . '</td>';
        $body .= '<td align=\'right\' class=\'td_servicio\' style=\'padding:3px\'>'. $totals['addons']*1.16 . '</td>';
        $body .= '<td align=\'right\' class=\'td_servicio\' style=\'padding:3px\'></td>';
        $body .= '<td align=\'right\' class=\'td_servicio\' style=\'padding:3px\'></td>';
        $body .= '<td align=\'right\' class=\'td_servicio\' style=\'padding:3px; font-weight:bold; \'>'. $totals['total']*1.16 . '</td>';


        $disk = 'review/';
        $path = public_path($disk);
        $pdfName = 'report_.pdf';

        //$html = view('admin.rfo.pdf', compact('data','activity'))->render();



/*  $html = "<!DOCTYPE html>
            <html>
            <head>
            </head>
                <body>
                <table border='1'>
                <tr>
                    <td>Cant</td>
                    <td>Descripcion</td>
                    <td>Caracteristicas</td>
                    <td>Periocidad</td>
                    <td>Precio</td>
                </tr>
                    $body
                </table>
                </body>
            </html>
            "; Funcional
            $pdf = PDF::loadHTML($html);*/
/* orig
        $pdf = PDF::loadHTML(view('admin.quotes.pdf',[]));// compact('arrayService') este es el correcto
        $pdf->output();
        $pdf->save($path.$pdfName);

*/
        //$html = view('admin.quotes.pdf', compact('data','activity'))->render();

        $pdf = PDF::loadHTML(view('admin.quotes.pdf', compact('body','conditions')));
        $pdf->output();

        $pdf->save($path.$pdfName);

        return response()->json(
            [
                'data' => $disk.$pdfName,
                'message' => '',
                'success' => true
            ]
        );

}//function getPdf



    //Function getPDF_orig, es la funcion que trabaja con el arreglo directo de los datos vpsList, serverList, cuando no se implementaba  lo de origen [0].vps
    public function getPDF_orig(Request $request)
    {   //change locale for date
        setlocale(LC_ALL, "es_ES");
       $params = json_decode($request->getContent());
/*
        return response()->json([
            //'data' => $params[1]->vpsList,
            'success' => true,
            'message' => $params[1],
        ]);*/




        // max length string
        /*$maxLength = 100;

        // General Information
        $title = Title::find($request->id_title)->name_title;
        $name = $request->name_customer;
        $user = User::find($request->id_user);
        $userName = $user->name_user;
        $userPosition = $user->position_user;
        $dc = DataCenter::find(2)->information_data_center;

        // Here comes the name of the previous uploaded image to be attached
        $imagesUploaded = json_decode($request->imagesUploaded, true);

        // Services with Cost scheme not Payment Cycle
        $servicesWithCost = ['VPS', 'FIREWALL', 'COLO', 'SWITCH'];

        // General Service Information
        $services = $request->services;
        $services = explode(' ', $services);
        $arrayService = array();
        $paymentName = "";
        $countServers = 1;
        $typeColo = false;
        $thirdpartySw = false;
        $servicesCount = 0;
        // print_r($request->all());
        // die();
        */

        //$servicesList = $params[1]->vpsList;
        $servicesList = $params[1];
        $servicesWithCost = ['serverList','vpsList','placementList'];
        $services = ['serverList','vpsList','placementList'];
        $servicesCount = 0;

        $body = '';
        foreach ($servicesList as $serviceType => $serviceTypeElem){

            foreach($serviceTypeElem as $elem){
            //    $element = array();
              //  $servicesCount++;

                if (in_array($serviceType, $servicesWithCost)) {
                    $payment = Cost::where('id', 46)->first();//$request[$service . '_payment_cost_id'])->first();
                    $paymentName = $payment['label'];
                    $paymentCharge = $payment['cost'];
                    $price = 600+rand(0,25000); //$request[$service . '_base_price']; // Services::query con esta llamada aun no probada aqui se puede obtener los datos de los precios, pero mejor enviarlos por formulario
               /*  return response()->json([
                    //'data' => $params[1]->vpsList,
                    'success' => true,
                    'message' => $payment,
                ]); */
                } else {
                    //empezar solo con los de pago normal
                /* $payment = PaymentCycle::where('charge_payment_cycle', '=', $request[$service . '_payment_cycle'])->get()->toArray();
                    $paymentName = $payment[0]['name_payment_cycle'];
                    $paymentCharge = $payment[0]['charge_payment_cycle'];
                    $price = $request[$service . '_base_price'] * $paymentCharge;*/
                }

                $cpPrice = 0;
                $subtotal = 0;
                $pricePromo = 0;
                $iva = 0;
                $cp = null;

                $finalPrice = $price *1.16;//$request[$service . '_price'];
                $discount = 0; //$request[$service . '_discount'];
                (isset($elem->datacenter)) ?
                    $dcName = DataCenter::find($elem->datacenter)->name :
                    $dcName = "";
                    $serviceName = '';

                (isset($elem->service)) ?
                    // $features = ServiceFeature::where('id_service_service_feature', '=', $request[$service . '_select'])->get() :
                    $features = ServiceFeature::where('id_service', $elem->service)->get() :
                    $features = null;

                (isset($elem->transfer)) ?
                    $transferName = Transfer::find($elem->transfer)->name_transfer :
                    $transferName = null;

                // Buscar precio de Panel de control
                if (isset($elem->controlPanel)) {
                    $cpPrice = Cost::where(['id_service' => $elem->controlPanel, 'table' => 'panel', 'label' => $paymentName])->first();
                    if($cpPrice==null){
                        $cpPrice = new \stdClass();
                        $cpPrice->cost = "0.00";
                    }

                    $controlpanelName = ControlPanel::find($elem->controlPanel)->name;

                }

                switch ($serviceType) {
                    case 'vpsList':
                        $serviceName = Service::find($elem->service)->name;


                        //array_push($element, '<p class="details"><strong> Enterprise ' . $serviceName . '</strong></p>');
                        /*
                        if ($features !== null) {
                            foreach ($features as $feature) {
                                array_push($element, '<p class="details">' . $feature->name_service_feature . '</p>');
                            }
                        }
                      //  array_push($element, '<p class="details">Enterprise Data Center - ' . $dcName . '</p>');
                        if ($cpPrice == 0) {
                            array_push($element, '<p class="details">Panel de control: ' . $cp . '</p>');
                        }*/
                        break;
                        default:
                        break;
                } // SWITCH END Services


               /*   return response()->json([
                    //'data' => $params[1]->vpsList,
                    'success' => true,
                    'message' => $serviceName,
                ]);
 */

            // Addons
            if (isset($elem->addons_selecteds) || $cpPrice != 0) {
                /*if ($type == 'cloud') {
                    array_push($element, '<p class="details">*Estimado ' . $paymentName . ': $' . number_format($price, 2, '.', ',') . ' MXN (IVA incluido) </p>');
                } else {*/
                    array_push($element, '<p class="details">Precio ' . $paymentName . ': $' . number_format($price, 2, '.', ',') . ' MXN (IVA incluido) </p>');
                //}
            }
            if ($cpPrice != 0) {
                $thirdpartySw = true;
                array_push($element, '<br>');
                array_push($element, '<p class="details" style="color: #F37720"><strong>Servicios Adicionales:</strong></p>');
                array_push($element, '<p class="details">' . $cp . ': &nbsp;&nbsp;&nbsp;$' . number_format($cpPrice, 2, '.', ',') . ' MXN (IVA incluido) **</p>');
            }
            $addonsPrice = 0;
            $addonscount = 0;
            $body_addons = '';
            if (isset($elem->addons_selecteds)) {
                if ($cpPrice == 0) {
                    array_push($element, '<br>');
                    array_push($element, '<p class="details" style="color: #F37720"><strong>Servicios Adicionales:</strong></p>');
                }
                foreach ($elem->addons_selecteds as $id_addon) {
                    $addonscount++;
                    $addon = Addon::find($id_addon);
                    $addon_type = AddonTypes::find($addon->type_id);

                    if (in_array($serviceType, $servicesWithCost)) {
                    //de donde sale $elem->addons_selecteds
                        $addonPrice = Cost::where(['id_service' => $request[$service . '_addon'], 'table' => 'addon', 'label' => $paymentName])->first()->cost;
                    } else {
                        $addonPrice = ($paymentCharge != 11) ? $addon->price_monthly * $paymentCharge : $addon->price_annual;
                    }

                    if (strpos($addon_type->key, 'SW_TERCEROS') !== false) {
                        $thirdpartySw = true;
                        array_push($element, '<p class="details">' . $addon->name . ':&nbsp;&nbsp;&nbsp;$' . number_format($addonPrice, 2, '.', ',') . ' MXN (IVA incluido) ** </p>');
                    } else {
                        array_push($element, '<p class="details">' . $addon->name . ':&nbsp;&nbsp;&nbsp;$' . number_format($addonPrice, 2, '.', ',') . ' MXN (IVA incluido) </p>');
                    }
                    $addonsPrice += $addonPrice;
                }
            }


                $body .= "<tr><td style='font-size:10px;' align='center'>1</td><td style='font-size:10px;'>";
                $body .= '<div>Datacenter: '.$elem->datacenter. ' ' . $dcName.'</div>';
                $body .= '<div>Control Panel:'. $elem->controlPanel.' '. $controlpanelName . '</div>';

                $body .= '<div><small> Enterprise '.$elem->service . ' '  . $serviceName . '</small></div></td><td style="font-size:10px;"">';
                $body .= "<div>Service Type: ".$serviceType."</div>";

                foreach($features as $feature){
                    $body .= '<small>' . $feature->name . ', </small>';
                }

                $body .= "</td><td style='font-size:10px;' align='center'>". $paymentName;
                $body .= "</td><td style='font-size:10px;' align='center'>$". $cpPrice->cost;
                $body .= "</td></tr>";


            }


        }




        $disk = 'review/';
        $path = public_path($disk);
        $pdfName = 'report_.pdf';

        //$html = view('admin.rfo.pdf', compact('data','activity'))->render();



  $html = "<!DOCTYPE html>
            <html>
            <head>
            </head>
                <body>
                <table border='1'>
                <tr>
                    <td>Cant</td>
                    <td>Descripcion</td>
                    <td>Caracteristicas</td>
                    <td>Periocidad</td>
                    <td>Precio</td>
                </tr>
                    $body
                </table>
                </body>
            </html>
            ";
            $pdf = PDF::loadHTML($html);
//        $pdf = PDF::loadHTML(view('admin.quotes.pdf', compact('arrayService'))); este es el correcto
        $pdf->output();


        $pdf->save($path.$pdfName);

        return response()->json(
            [
                'data' => $disk.$pdfName,
                'message' => '',
                'success' => true
            ]
        );

/*


            // Set Service Price
            if ($discount != 0) {
                //$pricePromo = $price - ( $price * $discount/100 ) + $addonsPrice + $cpPrice;
                $pricePromo = $finalPrice;
                $price = $price + $addonsPrice + $cpPrice;
                if (!isset($request['IVA_per_product'])) {
                    array_push($element, '<p class="details">Precio Total ' . $paymentName . ': $' . number_format($price, 2, '.', ',') . ' MXN (IVA incluido)</p>');
                    array_push($element, '<p class="details"><strong>Precio Promoción ' . $paymentName . ' : $' . number_format($pricePromo, 2, '.', ',') . ' MXN (IVA incluido)</strong></p>');
                    array_push($element, '<hr style="width:100%;">');
                } else {

                    $subtotal = $price / 1.16;
                    $iva = $price - $subtotal;
                    array_push($element, '<p class="details">Precio Total ' . $paymentName . ': $' . number_format($price, 2, '.', ',') . ' MXN (IVA incluido)</p>');
                    array_push($element, '<p class="details">Subtotal Promoción ' . $paymentName . ': $' . number_format($subtotal, 2, '.', ',') . ' MXN</p>');
                    array_push($element, '<p class="details">IVA Promoción ' . $paymentName . ': $' . number_format($iva, 2, '.', ',') . ' MXN </p>');
                    array_push($element, '<p class="details"><strong>Precio Promoción ' . $paymentName . ' : $' . number_format($pricePromo, 2, '.', ',') . ' MXN (IVA incluido)</strong></p>');
                    array_push($element, '<hr style="width:100%;">');
                }
            } else {
                $price = $price + $addonsPrice + $cpPrice;
                //Validacion de si tiene segundo disco para sumarselo al total y calcular subtotal e IVA
                if (!isset($request['IVA_per_product'])) {
                    if ($type == 'cloud') {
                        array_push($element, '<p class="details"><strong>*Estimado ' . $paymentName . ' Total: $' . number_format($price, 2, '.', ',') . ' MXN (IVA incluido)</strong></p>');
                        array_push($element, '<hr style="width:100%;">');
                    } else {
                        array_push($element, '<br>');
                        array_push($element, '<p class="details"><strong>Total ' . $paymentName . ': $' . number_format($price, 2, '.', ',') . ' MXN (IVA incluido)</strong></p>');
                        array_push($element, '<hr style="width:100%;">');
                    }
                } else {
                    $subtotal = $price / 1.16;
                    $iva = $price - $subtotal;
                    array_push($element, '<p class="details"><strong>Subtotal ' . $paymentName . ': $' . number_format($subtotal, 2, '.', ',') . ' MXN</strong></p>');
                    array_push($element, '<p class="details"><strong>IVA ' . $paymentName . ': $' . number_format($iva, 2, '.', ',') . ' MXN </strong></p>');
                    array_push($element, '<p class="details"><strong>Total ' . $paymentName . ': $' . number_format($price, 2, '.', ',') . ' MXN (IVA incluido)</strong></p>');
                    array_push($element, '<hr style="width:100%;">');
                }
            }

            array_push($arrayService, $element);*/
//        } //foreach ($servicesList as $service





/*************ORIG************************************************************************ */
/*
        foreach ($services as $service) { //orig
            // For each service
            $element = array();
            $servicesCount++;
            // Particular Service Information
            $type = explode('_', $service);
            $type = $type[0];

            if (in_array(strtoupper($type), $servicesWithCost)) {
                $payment = Cost::where('id', $request[$service . '_payment_cost_id'])->first();
                $paymentName = $payment['label'];
                $paymentCharge = $payment['cost'];
                $price = $request[$service . '_base_price'];
            } else {
                $payment = PaymentCycle::where('charge_payment_cycle', '=', $request[$service . '_payment_cycle'])->get()->toArray();
                $paymentName = $payment[0]['name_payment_cycle'];
                $paymentCharge = $payment[0]['charge_payment_cycle'];
                $price = $request[$service . '_base_price'] * $paymentCharge;
            }

            $cpPrice = 0;
            $subtotal = 0;
            $pricePromo = 0;
            $iva = 0;
            $cp = null;

            $finalPrice = $request[$service . '_price'];
            $discount = $request[$service . '_discount'];
            (isset($request[$service . '_dc'])) ?
                $dcName = DataCenter::find($request[$service . '_dc'])->name_data_center :
                $dcName = "";
            $serviceName = '';
            (isset($request[$service . '_select'])) ?
                $features = ServiceFeature::where('id_service_service_feature', '=', $request[$service . '_select'])->get() :
                $features = null;
            ($request[$service . '_transfer'] != null) ?
                $transferName = Transfer::find($request[$service . '_transfer'])->name_transfer :
                $transferName = null;

            // Buscar precio de Panel de control
            if (isset($request[$service . '_control_panel'])) {
                // $cost = Cost::where(['id_service' => $request[$service . '_controlpanel_id'], 'table' => 'panel', 'label' => $paymentName])->first();
                $cp = ControlPanel::find($request[$service . '_control_panel'])->name_control_panel;
                $cpPrice = $request[$service . '_controlpanel_price']; // $cost->cost;
            }

            // Calculating service price and adding special requiments.
            switch ($type) {
                case 'vps':
                    $serviceE = Service::find($request[$service . '_select']);
                    $serviceName = $serviceE->name_service;
                    array_push($element, '<p class="details"><strong> Enterprise ' . $serviceName . '</strong></p>');

                    if ($features !== null) {
                        foreach ($features as $feature) {
                            array_push($element, '<p class="details">' . $feature->name_service_feature . '</p>');
                        }
                    }
                    array_push($element, '<p class="details">Enterprise Data Center - ' . $dcName . '</p>');
                    if ($cpPrice == 0) {
                        array_push($element, '<p class="details">Panel de control: ' . $cp . '</p>');
                    }
                    break;
                case 'colo':
                    $serviceE = Service::find($request[$service . '_select']);
                    $serviceName = $serviceE->name_service;
                    $typeColo = true;
                    array_push($element, '<p class="details"><strong> Enterprise ' . $serviceName . '</strong></p>');
                    if (isset($request[$service . '_name']) & $request[$service . '_name'] != null) {
                        array_push($element, '<p class="details">Equipo: ' . $request[$service . '_name'] . '</p>');
                        array_push($element, '<br>');
                    }

                    if ($features !== null) {
                        foreach ($features as $feature) {
                            $featureSplited = preg_split("/.{0,{$maxLength}}\K(\s+|$)/", $feature->name_service_feature, 0, PREG_SPLIT_NO_EMPTY);
                            foreach ($featureSplited as $feat) {
                                array_push($element, '<p class="details">' . $feat . '</p>');
                            }
                        }
                    }
                    array_push($element, '<p class="details">Enterprise Data Center - ' . $dcName . '</p>');
                    break;
                case 'firewall':
                case 'switch':
                    $serviceE = Service::find($request[$service . '_select']);
                    $serviceName = $serviceE->name_service;
                    array_push($element, '<p class="details"><strong>' . $serviceName . '</strong></p>');

                    if ($features !== null) {
                        foreach ($features as $feature) {
                            $featureSplited = preg_split("/.{0,{$maxLength}}\K(\s+|$)/", $feature->name_service_feature, 0, PREG_SPLIT_NO_EMPTY);
                            foreach ($featureSplited as $feat) {
                                array_push($element, '<p class="details">' . $feat . '</p>');
                            }
                        }
                    }
                    array_push($element, '<p class="details">Enterprise Data Center - ' . $dcName . '</p>');
                    if ($transferName != NULL)
                        array_push($element, '<p class="details">Ancho de banda mensual: ' . $transferName . '</p>');
                    break;
                case 'custom':
                    $serviceName = $request[$service . '_title'];
                    array_push($element, '<p class="details"><strong>' . $serviceName . '</strong></p>');

                    $details = explode("\n", $request[$service . '_details']);

                    foreach ($details as $detail) {
                        /*
                        $detailSplited = preg_split("/.{0,{$maxLength}}\K(\s+|$)/", $detail, 0, PREG_SPLIT_NO_EMPTY);
                        foreach ($detailSplited as $det) {
                            array_push($element, '<p class="details">' . $det . '</p>');
                        }*
                        if (ord($detail) == 13)
                            $detail = "&nbsp;";
                        array_push($element, '<p class="details">' . $detail . '</p>');
                    }

                    break;
                case 'server':
                    $serviceE = CPU::find($request[$service . '_cpu_select']);
                    $serviceName = $serviceE->name_cpu;
                    array_push($element, '<p class="details"><strong>Enterprise Quality Server #' . $countServers++ . '</strong></p>');
                    array_push($element, '<br>');
                    array_push($element, '<p class="details"><strong>' . $serviceName . '</strong></p>');

                    $ram = RAM::find($request[$service . '_ram_select'])->name_ram;
                    array_push($element, '<p class="details">' . $ram . ' RAM</p>');

                    $countDisks = 1;
                    if ($request[$service . '_main_storage_type'] == 0) {
                        $disk = Disk::find($request[$service . '_storage_main_disk_1'])->name_disk;
                        array_push($element, '<p class="details">Disco Duro ' . $countDisks++ . ': ' . $disk . '</p>');

                        if ($request[$service . '_storage_main_disk_2'] != null) {
                            $disk = Disk::find($request[$service . '_storage_main_disk_2'])->name_disk;
                            array_push($element, '<p class="details">Disco Duro ' . $countDisks++ . ': ' . $disk . '</p>');

                            //Sumamos el segundo disco aquí al total
                        }
                    } else {
                        $raid = Raid::find($request[$service . '_main_storage_type'])->name_raid;
                        array_push($element, '<p class="details">RAID: ' . $raid . '</p>');
                        $disk = Disk::find($request[$service . '_main_storage_raid_disk'])->name_disk;
                        for ($i = 1; $i <= $request[$service . '_main_storage_raid_number_disk']; $i++, $countDisks++) {
                            array_push($element, '<p class="details">Disco Duro ' . $countDisks . ': ' . $disk . '</p>');
                        }
                    }
                    if (isset($request[$service . '_extra_disk'])) {
                        foreach ($request[$service . '_extra_disk'] as $id_disk) {
                            $disk = Disk::find($id_disk)->name_disk;
                            array_push($element, '<p class="details">Disco Duro Extra: ' . $disk . '</p>');
                            //Sumamos el segundo disco aquí al total
                        }
                    }

                    if (isset($request[$service . '_extra_raid'])) {
                        $raid = Raid::find($request[$service . '_extra_raid'])->name_raid;
                        array_push($element, '<p class="details">RAID Secundario: ' . $raid . '</p>');

                        $disk = Disk::find($request[$service . '_extra_raid_disk'])->name_disk;
                        for ($i = 1; $i <= $request[$service . '_extra_raid_number_disk']; $i++) {
                            array_push($element, '<p class="details">Disco Duro ' . $i . ': ' . $disk . '</p>');
                        }
                    }

                    $administration = Administration::find($request[$service . '_administration'])->name_administration;
                    array_push($element, '<p class="details">' . $administration . '</p>');

                    $os = OperativeSystem::find($request[$service . '_so'])->name_operative_system;
                    array_push($element, '<p class="details">Sistema Operativo: ' . $os . '</p>');

                    if ($cpPrice == 0) {
                        array_push($element, '<p class="details">Panel de control: ' . $cp . '</p>');
                    }

                    $pulicPort = PublicPort::find($request[$service . '_public_port'])->name_public_port;
                    array_push($element, '<p class="details">Puerto publico: ' . $pulicPort . '</p>');

                    if ($request[$service . '_transfer'] != null) {
                        $transfer = Transfer::find($request[$service . '_transfer'])->name_transfer;
                        array_push($element, '<p class="details">' . $transfer . ' Transferencia Mensual Premium</p>');
                    }

                    if (strpos($serviceName, 'Atom') != true)
                        array_push($element, "<p class='details'> 1 Dirección IPv4 Dedicada (IPv6 Disponible) </p>");
                    else
                        array_push($element, "<p class='details'> Rango /29 (5 IP's) </p>");


                    if (strpos($cp, 'cPanel') !== false & $administration == "Administración Completa (Hardware, Red, OS y Panel de Control)")
                        array_push($element, "<p class='details'> KernelCare (Actualizaciones de Kernel sin reinicio) </p>");

                    array_push($element, '<p class="details">Enterprise Data Center - ' . $dcName . '</p>');
                    array_push($element, '<p class="details">Soporte en español 24/7</p>');
                    array_push($element, '<p class="details">Servidor Escalable (Procesador, RAM, Discos, Bandwidth)</p>');
                    array_push($element, '<p class="details">Acceso como usuario root (Full Access)</p>');
                    array_push($element, '<p class="details">Soporte Profesional vía chat, ticket y teléfono</p>');
                    array_push($element, '<p class="details">Auditoría de seguridad (Security Deployed)</p>');
                    array_push($element, '<p class="details">Garantía del 99.9% Mensual de Uptime</p>');
                    array_push($element, '<p class="details">Factura Fiscal del Servicio</p>');

                    break;
                case 'cloud':
                    array_push($element, '<p class="details"><strong> HostDime Enterprise Cloud Server </strong></p>');
                    $cloudQuery = Cloud::where('id_data_center_cloud', '=', '1')->get();
                    $cloud = $cloudQuery->pluck('name_cloud', 'key_cloud')->toArray();
                    $cloudUnits = $cloudQuery->pluck('unit_cloud', 'key_cloud')->toArray();
                    $cloudIncluded = $cloudQuery->pluck('included_cloud', 'key_cloud')->toArray();

                    foreach ($cloud as $key => $cloudName) {
                        if ((float)$cloudIncluded[$key] > (float)$request[$service . '_' . $key]) {
                            array_push($element, '<p class="details">' . $cloudName . ': ' . $cloudIncluded[$key] . ' ' . $cloudUnits[$key] . '</p>');
                        } else {
                            switch ($key) {
                                case 'auto_escalable':
                                    if ($request[$service . '_' . $key] == 1) {
                                        array_push($element, '<p class="details">Auto escalable</p>');
                                    }
                                    break;
                                case 'bw_entrada':
                                    array_push($element, '<p class="details">' . $cloudName . ': ILIMITADO </p>');
                                    break;
                                default:
                                    array_push($element, '<p class="details">' . $cloudName . ': ' . $request[$service . '_' . $key] . ' ' . $cloudUnits[$key] . '</p>');
                                    break;
                            }
                        }
                    }

                    $administration = Administration::find($request[$service . '_administration'])->name_administration;
                    array_push($element, '<p class="details">' . $administration . '</p>');

                    $os = OperativeSystem::find($request[$service . '_so'])->name_operative_system;
                    array_push($element, '<p class="details">Sistema Operativo: ' . $os . '</p>');

                    if ($features !== null) {
                        foreach ($features as $feature) {
                            $featureSplited = preg_split("/.{0,{$maxLength}}\K(\s+|$)/", $feature->name_service_feature, 0, PREG_SPLIT_NO_EMPTY);
                            foreach ($featureSplited as $feat) {
                                array_push($element, '<p class="details">' . $feat . '</p>');
                            }
                        }
                    }
                    array_push($element, '<p class="details">Enterprise Data Center - ' . $dcName . '</p>');
                    if ($cpPrice == 0) {
                        array_push($element, '<p class="details">Panel de control: ' . $cp . '</p>');
                    }
                    break;
                default:
                    break;
            } // SWITCH END Services
            // Addons
            if ($type == 'cloud') {
                array_push($element, '<p class="details">Precio por hora: $' . number_format($price / 730, 6, '.', ',') . ' MXN (IVA incluido) </p>');
            }
            if (isset($request[$service . '_addon']) || $cpPrice != 0) {
                if ($type == 'cloud') {
                    array_push($element, '<p class="details">*Estimado ' . $paymentName . ': $' . number_format($price, 2, '.', ',') . ' MXN (IVA incluido) </p>');
                } else {
                    array_push($element, '<p class="details">Precio ' . $paymentName . ': $' . number_format($price, 2, '.', ',') . ' MXN (IVA incluido) </p>');
                }
            }
            if ($cpPrice != 0) {
                $thirdpartySw = true;
                array_push($element, '<br>');
                array_push($element, '<p class="details" style="color: #F37720"><strong>Servicios Adicionales:</strong></p>');
                array_push($element, '<p class="details">' . $cp . ': &nbsp;&nbsp;&nbsp;$' . number_format($cpPrice, 2, '.', ',') . ' MXN (IVA incluido) **</p>');
            }
            $addonsPrice = 0;
            $addonscount = 0;
            if (isset($request[$service . '_addon'])) {
                if ($cpPrice == 0) {
                    array_push($element, '<br>');
                    array_push($element, '<p class="details" style="color: #F37720"><strong>Servicios Adicionales:</strong></p>');
                }
                foreach ($request[$service . '_addon']  as $id_addon) {
                    $addonscount++;
                    $addon = Addon::find($id_addon);
                    $addon_type = AddonTypes::find($addon->addon_type_id);
                    if (in_array(strtoupper($type), $servicesWithCost)) {
                        $addonPrice = Cost::where(['id_service' => $request[$service . '_addon'], 'table' => 'addon', 'label' => $paymentName])->first()->cost;
                    } else {
                        $addonPrice = ($paymentCharge != 11) ? $addon->price_monthly_addon * $paymentCharge : $addon->price_annual_addon;
                    }

                    if (strpos($addon_type->key_addon_type, 'TERCEROS') !== false) {
                        $thirdpartySw = true;
                        array_push($element, '<p class="details">' . $addon->name_addon . ':&nbsp;&nbsp;&nbsp;$' . number_format($addonPrice, 2, '.', ',') . ' MXN (IVA incluido) ** </p>');
                    } else {
                        array_push($element, '<p class="details">' . $addon->name_addon . ':&nbsp;&nbsp;&nbsp;$' . number_format($addonPrice, 2, '.', ',') . ' MXN (IVA incluido) </p>');
                    }
                    $addonsPrice += $addonPrice;
                }
            }

            // Set Service Price
            if ($discount != 0) {
                //$pricePromo = $price - ( $price * $discount/100 ) + $addonsPrice + $cpPrice;
                $pricePromo = $finalPrice;
                $price = $price + $addonsPrice + $cpPrice;
                if (!isset($request['IVA_per_product'])) {
                    array_push($element, '<p class="details">Precio Total ' . $paymentName . ': $' . number_format($price, 2, '.', ',') . ' MXN (IVA incluido)</p>');
                    array_push($element, '<p class="details"><strong>Precio Promoción ' . $paymentName . ' : $' . number_format($pricePromo, 2, '.', ',') . ' MXN (IVA incluido)</strong></p>');
                    array_push($element, '<hr style="width:100%;">');
                } else {

                    $subtotal = $price / 1.16;
                    $iva = $price - $subtotal;
                    array_push($element, '<p class="details">Precio Total ' . $paymentName . ': $' . number_format($price, 2, '.', ',') . ' MXN (IVA incluido)</p>');
                    array_push($element, '<p class="details">Subtotal Promoción ' . $paymentName . ': $' . number_format($subtotal, 2, '.', ',') . ' MXN</p>');
                    array_push($element, '<p class="details">IVA Promoción ' . $paymentName . ': $' . number_format($iva, 2, '.', ',') . ' MXN </p>');
                    array_push($element, '<p class="details"><strong>Precio Promoción ' . $paymentName . ' : $' . number_format($pricePromo, 2, '.', ',') . ' MXN (IVA incluido)</strong></p>');
                    array_push($element, '<hr style="width:100%;">');
                }
            } else {
                $price = $price + $addonsPrice + $cpPrice;
                //Validacion de si tiene segundo disco para sumarselo al total y calcular subtotal e IVA
                if (!isset($request['IVA_per_product'])) {
                    if ($type == 'cloud') {
                        array_push($element, '<p class="details"><strong>*Estimado ' . $paymentName . ' Total: $' . number_format($price, 2, '.', ',') . ' MXN (IVA incluido)</strong></p>');
                        array_push($element, '<hr style="width:100%;">');
                    } else {
                        array_push($element, '<br>');
                        array_push($element, '<p class="details"><strong>Total ' . $paymentName . ': $' . number_format($price, 2, '.', ',') . ' MXN (IVA incluido)</strong></p>');
                        array_push($element, '<hr style="width:100%;">');
                    }
                } else {
                    $subtotal = $price / 1.16;
                    $iva = $price - $subtotal;
                    array_push($element, '<p class="details"><strong>Subtotal ' . $paymentName . ': $' . number_format($subtotal, 2, '.', ',') . ' MXN</strong></p>');
                    array_push($element, '<p class="details"><strong>IVA ' . $paymentName . ': $' . number_format($iva, 2, '.', ',') . ' MXN </strong></p>');
                    array_push($element, '<p class="details"><strong>Total ' . $paymentName . ': $' . number_format($price, 2, '.', ',') . ' MXN (IVA incluido)</strong></p>');
                    array_push($element, '<hr style="width:100%;">');
                }
            }

            array_push($arrayService, $element);
        }

        //Create section for PDF
        $totals = array();

        // TOTAL OF TOTALS
        if (isset($request['plus_total'])) {
            array_push($totals, '<br>');
            if (isset($request['IVA_per_total'])) {
                //Validacion de si tiene segundo disco para sumarselo al total y calcular subtotal e IVA

                $subtotal = $request['total_mount'] / 1.16;
                $iva = $request['total_mount'] - $subtotal;
                array_push($totals, '<p class="plus_total"><strong>Gran subtotal ' . $paymentName . ': $' . number_format($subtotal, 2, '.', ',') . ' MXN</strong></p>');
                array_push($totals, '<p class="plus_total"><strong>IVA total' . ': $' . number_format($iva, 2, '.', ',') . ' MXN</strong></p>');
                array_push($totals, '<p class="plus_total"><strong>GRAN TOTAL ' . strtoupper($paymentName) . ': $' . number_format($request['total_mount'], 2, '.', ',') . ' MXN</strong></p>');
            } else {
                array_push($totals, '<p class="plus_total"><strong>GRAN TOTAL ' . strtoupper($paymentName) . ': $' . number_format($request['total_mount'], 2, '.', ',') . ' MXN (IVA incluido)</strong></p>');
            }
            array_push($totals, '<br>');
            array_push($arrayService, $totals);
        }

        //Create section termins for PDF, explode for get line by line.
        if (trim($request['additional_details'])) {
            $additional = array('<p class="details"><strong>DETALLES ADICIONALES:</strong><br><br>');

            $terms = explode("\n", $request['additional_details']);

            foreach ($terms as $term) {
                if (!empty($term)) {
                    $termLeng = strlen($term);
                    if (ord($term) == 13)
                        $term = "<br>";
                    if ($termLeng > 90) {
                        $start = 0;
                        $end = 90;
                        while ($start < $termLeng) {
                            $termTemp = substr($term, $start, 90);
                            array_push($additional, '<p class="details">' . $termTemp . '</p>');
                            $start = $end;
                            if (($end + 90) > $termLeng) {
                                $end = $termLeng;
                            } else {
                                $end += 90;
                            }
                        }
                    } else {
                        array_push($additional, '<p class="details">' . $term . '</p>');
                    }
                }
            }
            array_push($additional, '<br>');
            array_push($arrayService, $additional);
        }

        $terms = array();

        array_push($terms, '<p class="terms">* Cotización válida por ' . $request['date_expire'] . ' días a partir de la fecha de emisión.</p>');

        if ($typeColo) {
            array_push($terms, '<p class="terms">* Los servicios de Colocación incluyen soporte a conexión de red y conexión eléctrica únicamente.</p>');
            array_push($terms, '<p class="terms">* Al contratar un Rack, el cliente debe instalar sus propios switchs, rieles, cables ethernet, cables de poder y PDUs.</p>');
        }
        if ($type == 'cloud') {
            array_push($terms, '<p class="terms">* El servicio cloud se factura por hora. Las estimaciones mensuales se basan en un total de 730 horas
                                        (promedio de horas de un mes en el año) este valor varia según el mes</p>');
        }
        if ($thirdpartySw) {
            array_push($terms, '<p class="terms">** El costo de todo el software de terceros esta sujeto a cambios ocasionados por el alza de precio del proveedor,
                                        los cambios serán avisados al cliente con al menos 1 mes de anticipación.</p>');
        }

        if ($terms) {
            array_push($terms, '<br>');
            array_push($arrayService, $terms);
        }

        // Save to DB
        Quote::create(
            [
                'user_id' => $request->id_user,
                'dc' => '',
                'title' => $title,
                'name' => $name,
                'position' => $userPosition,
                'user_name' => $userName,
                'content' => serialize($arrayService),
                'services' => $servicesCount,
                'images' => serialize($imagesUploaded)
            ]
        );

        $view = View::make('quote.pdf', compact('dc', 'title', 'name', 'userPosition', 'userName', 'arrayService', 'servicesCount', 'imagesUploaded'))->render();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($view);

        //show PDF file
        return $pdf->stream(str_replace(' ', '', $name) . '.pdf');
        */
    }//function getPdf_orig


    /**
     * Show price of specific service
     *
     * @param int $idS
     * @return response()->json(array)
     */
    public function getServicePrice($table,$id_service,$billing_cycle)
    {
        $service = Price::where([
            ['id_service', '=', $id_service],
            ['label', '=', $billing_cycle],
            ['table_ref', '=', $table.'s']
        ])->first();

        if (!empty($service))
            return $service;
        else
            return response()->json(array('errors' => array('No existe servicio seleccionado')));
    }//function getServicePrice($idS..


    public function getServerPrice(request $request){
        setlocale(LC_ALL, "es_ES");
        //$params = json_decode($request->getContent());
        $params = json_decode($request->getContent(), true); //Devuelve un objeto data{ datacenter: 2, ... }, sin embargo internamente este objeto es transparente y se accede directamente a las propiedades del mismo $params['datacenter']

        /*         return response()->json([
                    'data' => $params['datacenter'],
                    'success' => true,
                    'message' => '',
                ]);*/

        $service_price = new \stdClass();
        $service_price->price = 0;
        $service_price->detalle = [];

        $cpu = CPU::find($params['cpu']);

        $service_price->price += $cpu->price;
        $service_price->detalle['cpu'] = $cpu->price;

        //Si los valores en discos, ram, etc son iguales a los que marca el equipo de fabrica entonces buscar el precio.
        if($cpu->id_disk_1!=$params['disk1']){
            $disk1 = Disk::find($params['disk1'])->price;
            $disk_final_price = $disk1;
            switch($params['disk1']){
                case 6:
                case 7:
                case 8:
                    $disk_final_price -= 200;
                break;
                case 10:
                    $disk_final_price -= 500;
                break;
            }//switch($params->disk1..

            $service_price->price += $disk_final_price;
            $service_price->detalle['disco1'] = $disk_final_price;
        }

        if($params['disk2']!='' && $cpu->id_disk_2!=$params['disk2']) {
            $disk2 = Disk::find($params['disk2'])->price;
            $service_price->price += $disk2;
            $service_price->detalle['disco2'] = $disk2;
        }


        $administration = Administration::find($params['administration'])->price;
        $service_price->price += $administration;
        $service_price->detalle['administration'] = $administration;

        $operative_system = OperativeSystem::find($params['operativeSystem'])->price;
        $service_price->price += $operative_system;
        $service_price->detalle['operative_system'] = $operative_system;

        $public_port = PublicPort::find($params['publicPort'])->price;
        $service_price->price += $public_port;
        $service_price->detalle['public_port'] = $public_port;

        $ram = 0;
        if($params['ram']!=$cpu->ram){ //No se cobra adicional por la Ram del paquete, solo si cambia de Ram se cobra
            $ram = RamCpu::where('id_cpu', '=', $params['cpu'])->where('id_ram', '=', $params['ram'])->value('price');
        }
        $service_price->price += $ram;
        $service_price->detalle['ram'] = $ram;

        $transfer = Transfer::find($params['transfer'])->price;
        $service_price->price += $transfer;
        $service_price->detalle['transfer'] = $transfer;

        /*** RAID, Calcular cantidad de discos para aplicar descuentos
        //Si el tipo de disco es igual al disco1 o disco2 por defecto del cpu aplica, un descuento
        //Vea la funcionalidad original en el archivo quote.js del anterior cotizador, use la siguiente linea 1694 para guiarse: totalAmountDisk = numberDisk * price_disk_type_selected
        ***/

        /*return response()->json([
            'data' => ($params['raid']['qty_disk']>0),
            'success' => true,
            'message' => '',
        ]);*/

        if($params['raid']['raid']!=''){
            $raid = Administration::find($params['raid']['raid'])->price;
            $service_price->price += $raid;
            $service_price->detalle['raid'] = $raid;


            if($params['raid']['qty_disk']>0){
                $disk_raid = Disk::find($params['raid']['disk'])->price;

                $disk_final_price =  $params['raid']['qty_disk'] * $disk_raid->price;
                $discount_factor = 2;
                $disk_qty = $params['raid']['qty_disk'];

                if ($cpu->id_disk_1 == $params['raid']['disk']) {
                    $disk_qty -= 1;
                    $discount_factor--;
                }

                if ($cpu->id_disk_2 == $params['raid']['disk']) {
                    $disk_qty -= 1;
                    $discount_factor--;
                }

                switch ($params['raid']['disk']) {
                    case '5':
                    case '6':
                    case '7':
                        $discount = $discount_factor * 200;
                        $disk_final_price -= $discount;
                        break;
                    case '8':
                    case '9':
                        $discount = $discount_factor * 100;
                        $disk_final_price -= $discount;
                        break;
                    case '10':
                        $disk_final_price -= $disk_raid;
                    break;
                }

                $service_price->price += $disk_final_price;
                $service_price->detalle['raid_disk'] = $disk_final_price;
            }
        }//if($params['raid']['raid']!=''..

        if(count($params['extraRaid'])>0){

            $extraraid = Administration::find($params['extraRaid']['raid'])->price;
            $service_price->price += $extraraid;
            $service_price->detalle['extraraid'] = $extraraid;

            $extraraid_disk = Disk::find($params['extraRaid']['disk'])->price;
            $service_price->price += $extraraid_disk;
            $service_price->detalle['extraRaid'] = $extradisk_raid;

            $disk_final_price =  $params['extraRaid']['qty_disk'] * $extradisk_raid->price;
            $service_price->price += $disk_final_price;
            $service_price->detalle['extraRaid_disk'] = $disk_final_price;
        }

        /** Discos Duros */
        if(count($params['hardDisks'])>0){
            foreach($params['hardDisks'] as $extra_disk ){
                $price_extra_disc = Disk::find($params['hardDisks']['disk'])->price;
                $service_price->price += $price_extra_disc->price;
            }
        }


        return response()->json(
            [
                'data' => $service_price,
                'message' => '',
                'success' => true
            ]
        );


    }//getServerPrice($request $request..
}
