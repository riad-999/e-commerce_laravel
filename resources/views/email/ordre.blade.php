<!DOCTYPE html>
<html lang="fr" style="box-sizing: border-box;">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>votre commande</title>
</head>

<body>
    <div class="es-wrapper-color" style="width: 100%; max-width: 500px; margin: 16px auto 16px;">
        <table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0">
            <tbody>
                <tr>
                    <td class="esd-email-paddings" valign="top">
                        {{-- <table class="es-content" cellspacing="0" cellpadding="0" align="center">
                            <tbody>
                                <tr></tr>
                                <table cellspacing="0" cellpadding="0" align="right">
                                    <tbody>
                                        <tr class="es-hidden">
                                            <td class="es-m-p20b esd-container-frame"
                                                esd-custom-block-id="7704" width="170"
                                                align="left">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>                                              
                            </tbody>
                        </table> --}}
                        <table class="es-content" cellspacing="0" cellpadding="0" align="center">
                            <tbody>
                                <tr>
                                    <td class="esd-stripe" align="center">
                                        <table class="es-content-body" cellspacing="0" cellpadding="0"
                                            bgcolor="#ffffff" align="center">
                                            <tbody>
                                                <tr>
                                                    <td class="esd-structure es-p40t es-p35r es-p35l" align="left">
                                                        <table width="100%" cellspacing="0" cellpadding="0">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="esd-container-frame"
                                                                        valign="top" align="center">
                                                                        <table width="100%" cellspacing="0"
                                                                            cellpadding="0">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td class="esd-block-image es-p25t es-p25b es-p35r es-p35l"
                                                                                        style="font-size:0"
                                                                                        align="center">
                                                                                        <a
                                                                                            target="_blank"
                                                                                            href="https://viewstripo.email/"><img
                                                                                                src="https://tlr.stripocdn.email/content/guids/CABINET_75694a6fc3c4633b3ee8e3c750851c02/images/67611522142640957.png"
                                                                                                alt
                                                                                                style="display: block;"
                                                                                                width="120">
                                                                                        </a>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="esd-block-text es-p10b"
                                                                                        align="center">
                                                                                        <h2>
                                                                                            @if($admin)
                                                                                                Nouvelle Commande
                                                                                            @else
                                                                                                Merci Pour Commander!
                                                                                            @endif
                                                                                        </h2>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="es-content" cellspacing="0" cellpadding="0" align="center">
                            <tbody>
                                <tr>
                                    <td class="esd-stripe" align="center">
                                        <table class="es-content-body" cellspacing="0" cellpadding="0"
                                            bgcolor="#ffffff" align="center">
                                            <tbody>
                                                <tr>
                                                    <td class="esd-structure es-p35r es-p35l" align="left">
                                                        <table width="100%" cellspacing="0" cellpadding="0">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="esd-container-frame" 
                                                                        valign="top" align="center">
                                                                        <table width="100%" cellspacing="0"
                                                                            cellpadding="0">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td class="esd-block-text es-p10t es-p10b es-p10r es-p10l"
                                                                                        align="left">
                                                                                        <table style="width: 100%"
                                                                                            class="cke_show_border"
                                                                                            cellspacing="1"
                                                                                            cellpadding="1" border="0"
                                                                                            align="left">
                                                                                            <tbody>
                                                                                                @foreach($cart as $item)
                                                                                                    <tr>
                                                                                                        <td style="padding: 5px 10px 5px 0"
                                                                                                            width="80%"
                                                                                                            align="left">
                                                                                                            <p>
                                                                                                                {{$item->name}} X {{$item->quantity}}
                                                                                                            </p>
                                                                                                        </td>
                                                                                                        <td style="padding: 5px 0"
                                                                                                            width="20%"
                                                                                                            align="left">
                                                                                                            <p>
                                                                                                                @if($item->promo)
                                                                                                                    @if($item->cut && ($item->cut * $item->price / 100) < $item->promo)
                                                                                                                        {{floor($item->cut * $item->price / 100) * $item->quantity}}Da
                                                                                                                    @else
                                                                                                                        {{$item->promo * $item->quantity}}
                                                                                                                    @endif
                                                                                                                @elseif($item->cut)
                                                                                                                    {{floor($item->cut * $item->price / 100) * $item->quantity}}Da
                                                                                                                @else
                                                                                                                    {{$item->price * $item->quantity}}Da
                                                                                                                @endif
                                                                                                            </p>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                @endforeach
                                                                                                <tr>
                                                                                                    <td style="padding: 5px 10px 5px 0"
                                                                                                        width="80%"
                                                                                                        align="left">
                                                                                                        <p>Livraison</p>
                                                                                                    </td>
                                                                                                    <td style="padding: 5px 0"
                                                                                                        width="20%"
                                                                                                        align="left">
                                                                                                        <p>{{$order->shipment}}Da</p>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td style="padding: 5px 10px 5px 0"
                                                                                                        width="80%"
                                                                                                        align="left">
                                                                                                        <p>Sous-Totale</p>
                                                                                                    </td>
                                                                                                    <td style="padding: 5px 0"
                                                                                                        width="20%"
                                                                                                        align="left">
                                                                                                        <p>{{$sub_total}}Da</p>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="esd-structure es-p10t es-p35r es-p35l" align="left">
                                                        <table width="100%" cellspacing="0" cellpadding="0">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="esd-container-frame"
                                                                        valign="top" align="center">
                                                                        <table
                                                                            style="border-top: 3px solid #eeeeee; border-bottom: 3px solid #eeeeee;"
                                                                            width="100%" cellspacing="0"
                                                                            cellpadding="0">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td class="esd-block-text es-p15t es-p15b es-p10r es-p10l"
                                                                                        align="left">
                                                                                        <table style="width: 100%;"
                                                                                            class="cke_show_border"
                                                                                            cellspacing="1"
                                                                                            cellpadding="1" border="0"
                                                                                            align="left">
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <td width="80%">
                                                                                                        <h4>TOTALE</h4>
                                                                                                    </td>
                                                                                                    <td width="20%">
                                                                                                        <h4>{{$sub_total + $order->shipment}}Da
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="esd-structure es-p40t es-p40b es-p35r es-p35l"
                                                        esd-custom-block-id="7796" align="left">
                                                        <table class="es-left" cellspacing="0" cellpadding="0"
                                                            align="left">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="esd-container-frame es-m-p20b"
                                                                         align="left">
                                                                        <table width="100%" cellspacing="0"
                                                                            cellpadding="0">
                                                                            <tbody>
                                                                                {{-- <tr>
                                                                                    <td class="esd-block-text es-p15b"
                                                                                        align="left">
                                                                                        <h4>Address</h4>
                                                                                    </td>
                                                                                </tr> --}}
                                                                                <tr>
                                                                                    <td class="esd-block-text es-p10b"
                                                                                        align="left">
                                                                                        <p>{{$order->address}}</p>
                                                                                        <p>{{$wilaya->name}}</p> 
                                                                                        <p>{{$order->name}}</p>
                                                                                        <p>Date: {{now()->format('d-m-Y')}}</p>
                                                                                        <p>durée: {{$wilaya->duration}}</p>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>