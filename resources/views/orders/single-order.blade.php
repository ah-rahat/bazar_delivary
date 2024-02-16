@extends('layouts.app')
@section('content')
@if(Auth::user()->role === 'admin')
@include('layouts.admin-sidebar')
@else
@include('layouts.other-sidebar')
@endif
<meta name="csrf-token" content="{{ csrf_token() }}"/>
<div id="apps" v-cloak>
<div class="content-area">
    <div class="container-fluid mt10">
        <div class="row justify-content-center">
            <div class="col-md-12">

                @if( $get_order_total->get_order_total != $order_custumer->order_total)
                <div class="alert alert-danger" role="alert">
                    Order Amount Calculation ERROR!!!!
                </div>
                @endif
                    <div class="panel panel-info" style="margin-bottom: 8px;">
                        <div class="panel-body table-responsive" style="padding: 2px;" >
                        <table class="table" style="text-transform: uppercase;font-size: 12px;">
                            <tr>
                                <td style="border: 1px solid #cccccc54;">Order ID: <br><b style="color: #e91e63;">#{{ $order_custumer->order_id }}-{{ $order_custumer->coupon }}</b></td>
                                <td style="border: 1px solid #cccccc54;">Order Date: <br><b style="color: #e91e63;">
                                        {{ date('d M h:i a', strtotime($order_custumer->created_at)) }}</b></td>
                                <td style="border: 1px solid #cccccc54;">Phone: <br><b style="color: #e91e63;">{{ $order_custumer->phone }}</b></td>
{{--                                <td style="cursor: pointer;border: 1px solid #cccccc54;" @click="deliveryLocations({{ $order_custumer->order_id }})">Delivery Time: <i class="fa fa-pencil"></i> <br> <b style="color: #e91e63;">--}}
{{--                                        @if( $order_custumer->delivery_time)--}}
{{--                                               {{$order_custumer->delivery_time}}--}}
{{--                                        @else--}}
{{--                                           Regular Delivery--}}
{{--                                        @endif--}}
{{--                                    </b>--}}
{{--                                <div class="timeslots" v-if="timeSlots.length>0 && isActiveTime" style="z-index: 1000; box-shadow: 0px 0px 3px #d9d9d9;border-radius: 2px;position: absolute;width: 230px;background: #fff;padding: 3px;">--}}
{{--                                     <div class="eachsl" style="width: 100%;--}}
{{--display: block;float: left;margin-bottom: 5px;border: 1px solid #cccccc70;border-radius: 3px;cursor: pointer;--}}
{{--padding: 6px;"   v-for="(timeSlot, index) in timeSlots" @click="AssignTime('Today',timeSlot.start,timeSlot.end)" >--}}
{{--                                        <div class="pull-left">--}}
{{--                                            <img class="pull-left" style="margin-right: 10px;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIAAAACACAYAAADDPmHLAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAGd5JREFUeNrsXQmYVMW1PjMw7JMBCSouKIIorrggoj7FJe5LjM8oiMTduJKoUTFReJIoJmoUEZeobG7RJKjPDSGKiGvUqGhEURZBDCKigIAMMK/+1/8N1aerqm/PdPd0T/f5vvPB3L59+957Tp3zn6WqKhZ1OVOaILUwXG14S8NbG+5heBPDm/HftoarDNfx/ArD6w0vN/yN4Xn8d6bhOeRlhlc3tRfVvAk8QzPDmxruY/ggw7sa7mS4I7kiC78BZVhi+CsqxRTDrxmeb/j7Yn55FUVqASDgQwwfY3hnw10M/yDP97CaCvCR4f81/Kzhz8oKkDvqbPhYwycZ3tHwxgV2f8toHR4z/GfDs8sKkB0XdbDhi2jifxjze/DtKwx/YXiu4Y8Nf84RCzO+yvAayz3U8bfaGG5P7AC80N3wVuRqups49J3htw3fa3gilaOsABma+HMNn8zRno5WGp5l+AUyTPFiCruhPrqS9wPe3PB+hvvR9dTE+D4U8HHDIwvRKhSaAgDMXU4zv1maET6HL/Ypw59S6OvzeK+bEXvAQp1geCdGFiEgiXv9neEPywqQOuKvNHwKwzQfQehjDT9Bs76ygCKRbRmFnGW4VyD6WEHFHU4AWdIKAJ97oeGLaV59/hQv7G761eVFEFrDPQyiQncKgMZxhn9r+MtSVAAg+usN7+D5fJHhOwzfTxNfjASXdhTdWg/POQCq1xkenWcX1mgKgHDuj/Tzvhdyo+EHqAS5HKm2ma7N4W9VUxGuDij8S4x23m3KCvBTwzd7zP1yKsboLAm+LYEaRl5PhnTdCdSiVHGF+v01VARgDaSDP6Cf/oy+uy4L99Tf8LDAO4BL+H1TU4BWhm9haOei+/lSPm2gZdnX8OGGd2GiCCa4ZQPvfS0VcjHR+yTD0xneravnNXFvgw1fRmXU9BTf1edNQQG2J3Lv4/hsBl/Cc/WMz5H3P9XwAYa7Gu6Qp4Gzisr6Ol3VK/XMN/RiWHik47P5VIJnilkBjjd8lwMJw5SOIGeaJevOUOsI+tNCKGghJJ3GZ32zHiHk2TT71eozKNU1uXQJuVSAy4jytYDmUYBTMrzeoUTTsCTtYn7na/pwmO5Z/P/X9MUPWy8cpvw0+vpqxvTdJJGF3C5NUsomXOcdw6MMT8jQRezIUHcfx2dQrJ8XkwLAnw91HH+acf+cDK51omHc5GExzv2XJFLB/+RvvO+JsYFJFkiiXBz5+R6e+6qhpdmG/yLZ01vS1wXeMDze8D0ZuIcauoQLHJ9BYc+g+ylYBQCqvpXhjKabDP86g5eBEf9LgroQ/V0SBRcI/R8xw7mNaBE2shRgVypQHNqZShCVpNulUYQ7DY/J4D2ez4iohWMADTS8tFAV4B6OVlHx9cV8CXEI5vc3fNBKzzkzCSxf4AvOlBqqAPp+DzQ8gGDUR5M5ul+Med0fGb7P8BaOfAGw1ZJCUoAK+qmz1fFljHufjnkNjPgrxF/rx2j/k+EnJZEiri9lUwFsOoRYor9HeWuZ54B7/DbG9eByHpHUiug0KsHXDRVcZZZG/kiH8OcTqccR/o4MBW/yCP9JugK84D83UPiRsjVXf2ejdWwKLVdfWihNVYz/p9HFxcE0Rxt+WR3fn5igTSEowDACO5sAsI5jfJyOTufIPsTxGYo//00/OymLrmqlJGcb6yS7TRtv8LkOZFJHExJVaCMbLuESsjDhdKJDCX5EJatsTAW41IH2kb06lqAsRG2JGeDndAkYadchkmi8+GuOEjmnETR+RGHNz8HvTOUIHuiIMFoQ6zzDCCNEX1AJXnVESPc2FgbACP+bUqJvafZfTfPdbRgnu2JeuIIrYyhQNqiSIzAfnb2bM6lzjuOz2QzxXoxxjecktaB0Da1J3ixAD47cSgVwBsQQ/l4051r4axkmHpsn4YPWS/7aumEZkdpFn8Bix4DAYDopxjVOkNTu42EckHlRABRXHrQQdESDYwA++ER083RXx+fRclwnRd5nH4MmMJn0qiMyGU93FKKZHGgrlRzhCrrmQwFuM7yHOoakxR0xhP+ww99PJ6CZIqVDyFCiP+B+By64M4YSABDqbGFHKldGMm32q5rdMzkfiHyEOjaJIeDaNMJHPNvJkTjCwy6U0iNMLJnIkXygJbhmtIYw9+8Evo/P0MK+t3WsC8Pb53NhARCfj3KY7rMlPGeuN0e+q6f/LUl0y5YyvSyprWCRJUiHCX4tqaV0FMz2zYUC3OYw3+nCp60pfF9m71ZHDqGU6AiCP1dTCI7dResQymcgjFuikk13xsgvZKQAR9L824Qa9QuB77Sj8EMxLh5ypLirX6Ug/Ack3AZfQ7++feAcJN108Q1zFK7KlgK05Ei1z0V9/do038N3dBfQWArbrpNXUAlKyRIcReHrDibE8r9yxP54b6G070OSSJHbhOt0ywYI/IUkpmjZhDAkNKnhNMP/o44hLXwqUT9M1uGyIf9ewb/fkQKYLJFj2pahcEd1fDSF9gpdZy/rsy2oAKF0+OvEYy0s6wrr8peGWADEplc4tC0UsvWU1BYmgEWkQ6MK2O2SKBGvV/dyfAmM/mMc0dDtyg3i/y858izHBq4LLKbT8nifezVEAa5SN7vKoRA2NWc+wP4OMoRIc85xPPRgpQTTSkABpqmoabTD/a2kFV2gZAW32jlwbYC/jxXGur6+LqAjs0u27/kdzZePIFDd+g1XMM5zPqpmqPgtpeKMLQEFWGg9873iz+EvpTAHWMfaM6Ka6PlOLa1tf+vYlrJhxnQKhYpBmJ1zqfX3Ypp3XycK0ruvKd/2PCOI76VM9aVb6S61G3kyYIUh8P2U1TkgExeA8GOQOna9hNuQrlXCX8bwpFCFDzCGghbKzf0KWAGGSWqnEqxqK8/5yMj+Rh1DtnCPTBTgfOXHvw6YcRDmyJ+ojo2QhrdY5YpaML5GIusndGudC/Re4QouV8fgt88LfAfZxVfV814VVwGaSWox4lYJ959dJcktVu8S5BUqofd/B5W06ljA9/uUI86/UFIrsrYVGO4YpJ3jKMDBklyu/T4NOEOocZA6do0U8Lo4kmgBs9vH10kjTM3OkOBi7V7IbQi6Q9HGHOXWz4ujAIMluUFyooSXP9MAZVIAoJSp/gR3epc6BpzmWx4PynKTOnaylrlWAPj9vo543UfobN1fHbuhCEZTsRKqsXb1dGtJtNL76AkFwmE19g0pAABRB5VdCtWkh6hrIPx4sSynnBFM+j3q2OniriZG8ntW4btzQwowQP2NSRgrPBeH9vV2WIvy6M8tjVejGmsYHh04X7uNfWyFsRVgI4WMAZQeC1wYgKKt9ffHkt3e/TK5aYaktsqfHzj/TeU2utg5AVsB0Jdnd+0gpehb2BAg8Rh1bEzAWpQpu6QrfLsFQkJkcKcoNzDIpQAnOH7ENwVrJ0lu9EAY9VxZLnmj51VkthHxm48eUH/3jSK9SAGite108sFHAB4tVcz5dlkueSOU1R90hIQ+Qhey3bS7ZWQxIgVAhcletWqVhNe17af+/ltZJnmn6epvJO+qPecukOSkEIS/t60AfdSXAeh8rdpYeaurA2iUKb+EzqF/W393luQWcZvQfzBZHTvMVoCDHT7G1+ePREJ76++ZZfPfKLTUEXWFwkHdxbWnrQC7qA+nBi6klzTDTawpy6NR6DX1d5/AuVgQw87RIOvbIpodu7GK/+cFLrSr+vvdshwajT5WfwPHtfWc+5UK06EAHaAANZJc+0c/mq/xo42kNjTOKcuh0QiDzy7Tb0KE78sH2AMbct+uklpj73yxUFKnL9saZk9kwI9/UIQvrk5S1/2tK8LnWKIsMKz5Hp5z1zEctGkHKAASOvaadwj/fG1c26n4f2ZAWQqZVkpqzaJY+xb/of7eJXCuHqw9oADbqoOfBC6gpyjNLMIXhj75MZKcOkUiDFW2w4vweWboUZ0GCKYogJ6bFlqhulsaEFLohDkN6JXrL6krfWIS5jNUjlZF9ExaXp0C52pr3T7CADaFun+2LWIFwLpDIyT9ZJjTJAurb+WRvlH4pVr8C2gvV+e2xkNu6ggXfKQbD74skpeELlrXDBmkSOc6AOBJkjy5opAJdYE1Cgj61jFerbBPm0qHuQstRqw16wf0pZpbFNhLuswxEjBXERNdsEhlP0c4O1SysBBjlsn1rtsrBQ4pAICuneFt3twhLF9Wr0pSGxDRquxanBmh5DmSfsWwfBB6HOzsJUYAll63q2moZmLK9mvWM0ZLxs8ogGfYim7JhfCbqUFczb9dW+rVKgtQ2dxh/kJLpurPqgOaiomKvaXx08QARW2V2X/Ucd6HDJP6xgRU+aRo0cw4lIn8cgp02kl21t9tKFWq+1gj/r7FtY7RVQhUk8uXoymTjNg6vjTN8LHXFEhy5WtJno6Nnrh9PK6ih+O7hUC30K2u9XAmViAF1NWlAXr26FjuCJlcpeAVacLJfNIiYpFDrEgG8xyPs/w7IqFHVE4ELdWFsmElVv/o5XFJyP1jZ9WW1rtfHdMa/r+wdd+fD/nWOfw58gCFOgHUBn03SPJq5F2pFFGrFACfXslsshTWEnaLxZ12X+EA8b69ilpL8uphtdAIvf1I+8BNrM0g61RIhAaX8eoYgCHq5/uKexk75AJOL4Jnq9FCDShAlXL7q/GHrv13CfyYjpW3KRIFgBU4V1IbKUMEBcEKHqcW+LP9QAl1ufi7uTQw/w5f1Jm/zQM/Nlf9vZ0UD8EvnkLcMlONkjr6/DHq5VUw/v5ZAT+X3tLumwCQ1xb7O2AAXf3rHvgxXf3rKcVH4wj4utH0N+MgmMOXN02Sd/jCILnP+m6h0c5pZGSTLuZ9CgWYTY2JTMPWfCkuP/Iv+pgqSwFggpYVmRKsktTmiIjG8tnHKyUYw/c0vsCeRa/y9V7gXF3Mm1VJs24LcAtxL+wsDO1sJIrwaQdpejSBrqJOuQNYgkEF5v/3VHkZX4c27l/3c35QSbNn44DqgAKsUOdWpHEZxUzjHFFAM1qCQlGCnVQE85X4J/RspFwArOBHUABk65aoh+wcyAVoH7O9NF0a57AElQWkBNspVL8w4I47SXJKGaX8RVH4oNfn3S/wo3o780OkaVNkCVxK0NjRga4OvhuIAFBRtLO8cOWrIgWY7BCqL5/8oiT3DOxOU9TUlUALO4oOzm+ke0JWT0/SCU3o7edQlv8kEF5RQoVmbRIAgnZCCBFBH2n6NMGjBFi357xGuB/MA7SLV3Djvv0b4Nb1TqVTbAX4TJIngwII+jKCQJp6w+ZDpTRoPDGBRtdQgp/n+V708jxzxT+hZzOVs0H9Z7qtALUOcHdQGpNo5wmObsLRgOvZz3NYgpF5xASo/OmexYlpwGJrZcW/sBUApFcB7y/+fWemS3K5FxXEg6V06E6H78e7utdhIXJBAOm9VHgeylLq1V/ejgawrQBPqhACzZJbey641uFvBkrhdNDkg+6gEqxXvvZPeVACvXEEMrQLPOciWaR3FX3ANl12DDlLPUwoxBslyQ2h0Mr9pbQISnCmCr2iWUa5KiUDm+kK5djA+TupvA4WlXjJpQAuPwJf52vxxv6+umP2XCk9GkslWKcGz90S3uKlvgTX3EEldB4InK8TVm+J1URS6TANdocQKk2hTN+t6m9sLbdrCSoBkkJnKXcAS/DjLP8OBH+BY9D6sn9YAf2n6th9Gr3qUEIv+HBG4IbQYPGO0vxLpDRpLJXAdgfZnjqHKMOe/4/c/28D5x+srAVwwtMhBRCCGP2jPwyAwbsdYLBviSrBGAIuYIMrGC1kizpL6oZdEwPgD65b70EI4Sc1jLr2DEK8+Ikkd5qc41CMiDALBZnE3axjWKD4KCmvG5xN+oMkT3FbzIHm61zGNPjXrb9XU0Yz01kApIT1zBnMTPGtPYML/1Edwzz7k8syyxph1Q+9tdwECbetD3GAv5RuId/MoJsleQ5AV45oHwE8TlXHrpfC3YenmAhgcoQkz/9DLeaGNKGfHfsDl1znOtGnAJ9J6q4fABu+OQMw9dip6nsVrw4vy6/BdIEjH/MHCU/Nx6wsu5r7gQZ//0HtgY0jZxDVVlkhxWzG/y6aT7Bor1aJi8+S8Azbbpa7WFgiQt2Gz1wVAHHR+5ugcjHIwP5C/HX/3R3hOdyHcwJPaOPIyLTbm0ggi4QewKWe89Fxghk3PRVYwaaFHzrORxEJWbNNmH/AZIynmrjwUTR7nuFcLcPmUZ53+bwkN32ifW//wIBCGP53Sd4k8r1Qbibd7OCrJXnq0aaO0MImrFaBzSLtKWSdGCPrtQWOkER5Neo7AMg8oQRG/9FWLF/F0XqB47xRktrxOzSNNT1eCb+O7kDqqwCzJblHXhiKhDqBoYG/d4Qkd6go4UGVpBAVtjRVwjOuUzIYqZRgCPMpNj3G83yEKX23qGOo2j4eupkQBogIzR+nW2EgzAz6yx8K+CH88H6SvKr4zgwxofUPS+oOF6MJNOuauAIsoAs9zAJqFRwUnxIf3K1A3Fy6x28D1x1GqxrRWirR/NDNpMMAEaHsebvj2B2B76AJ8UX+m45Ge8xgU6YLaf4rHRGVfWwFTfuUwLUw2F5Sx2C5z0h3E3EVAIT9aO2FFbAGTS9JXXzQpv1pujqUhe+ki5hzaR445wyHG7YJEz6xWqhdtPuSbnpJuhvIZImYcyW5cbQNwV114DuYZ3eOuNcJqqPJL1Xhg26TRPNIrefzoWmED7pRUiu2l8QRfqYK8D6jApv2SZORAmHzqfM8D7lMyrRc3DUTJHuujeGadQ/GgxLuD8gYBNqEGL+vJDeA9qbJCW0bg+TR5wQpzSzgg63qujByqC1B4QPt3yWpvZeIoq5I81241/uV+0CKGCng1XFvoD6rhJ0hyXvVgFAMStcUeh8twRrH9ZB27lFCggcmQhPndZLaRxlH+MieIkNor9yO9zpIMlzWpj4KsJB+y15IoSWTOj1jKMHPHOFMP6Lc40pA+EiVPyvuuYVDYwi/A9+1nrdxlaTuJJYTBQBN4g/atBn9fbqwDzkAtI7pVcS2ZMSA0KhjExQ8TDVy+Ejv7qU+Qxr8rBg+vy1Hvl7mDgpxU31uqiELRQKk6I6XHSjgdGXgKUyEvOL47GJJlJZzbQ22Ygg6XvzbrWWL+tLNwVW2Vp+h+QYp8HvTXKMVE0S6LI9cy9n1vbFM8gA+QkZQN3+8wlH+RZrv4mUMZ9jimox6P8OcbG9MheraZNnQxo7euh0l+6ufb0mkfom4u6thMZFanxdD+OjIGugA14dKeIX3nFkAG8RNcoSHf5HwimPCvMJlVBZXQmkgE1AjJHV9m4YQchd2+IMy9sZZvD7S3L+URN7/SofwAdQGGz4xhvDbeYT/Eb//VUNuNBsKACGiZPySQwmekXgLSWHr2QPEPcGhLYHRG0TIe2ThnvWil2slO/2L3XivaL+62eMKJzFiGhnjeh1pYbXwEe6h3bvBK5lmwwXYWh8J0iZo+KkOBfHRj/kSfX4ZwnqUvzVZwgWS0L3Okg0FKVwTNfP6rHoKcHcgffMg8ae98Xu3EHfEoR7EBfs5hI939F42hJZNBYg09kFJnS6+ijmAuMustaCJxM2F1iKcR9A5jUmqpXlSgFYEdn04EncLnLuIWAYZ07g7rEGhxjgiqpnEW1nDRNlWgOjljJPUGSnCUOVqCe9KYlN7AqgBMTDA5zSvb9I/zgi88LZUno6WAvQU/45paGbZicoIRcHKHNumuR/89l/5zJ9k8P4u4HdaquNvZ8vs51oBhIj+HnGXIyEkLKYwN4PrtWcMPSDGi49oCc0k/PH7/D24i5UEgUg/R4smoUHjaL7c1vwc/ntngsXdJXVFzlCi7HGO+HkZPCPu5TpxLzmD3MFJDQV8+VSAiDDar5HUcueXFOhD9bAuRzLu3VP8M5bSgb86Sd0rKTpeVQ9wvJxKhiTNIxKzEmdRP0m0gO3o+GwM3WdO9l7ItQKAfiKJZpJNPTmEq+tp1jZhsqg/rcLmec7sfcX7fpI+fm49rtGJA2GIIw+ymu/mxlw+RD4UANSdLuEAx2cwy+gLQFZxRT2vX0NABjO+F811Zwk3WmRqORbRvL/H8HZqAxJHzTgw4Ca6Oj7/iG5yaq4Fky8FiMIluIPLHQAHhMkLmFzyRBZi8nZMQvUiaOtJd1HD+2hBP1+hzDjcQC3/D8X8kGDyLYZf32bhPfSlr+/n+Ry1/IsyiGiKRgEi+i/Gw75GBOS2r6X2r8+BEjaTDVutVciGJtTvrYRQLnoTdmN+4yTP52gWvVIyaOYoVgUQWoAhjPV9O5QgBXw9FWKFFCdV0jVdKonGThe4rCV4HCKNsBNrYylARABvwyRRC/AtRYNFFtA7h7lts4tE8JsS7wyW8FoJUwn0pjfWjTa2AkS0N83+QeJfaQzx+3OSKIwgKfLvAhN6e+YNBhLghUJUYIrhkmbSRikpQETIew8lQGqeJgTD6HmYIG2e5H+PQuCHrWjFYN6PkcReCyF6k2Hdo1Igi2cUmgJE1IeACYrQIc25a4jQkS1Ddg85/sW0ENmcZRSVjLvwvtDQinbsdBtMI55/jYJ/Rgps1ZRCVYCIMKLOIUaIuz/ReoZxSMy8z1BuFgHWclqKNbKhHBxFAgBorQlQ21HxMLp7MJRELQI1gaqY94HfR9p7lPi3pykrQEzCS8f+fmcSLzRkXeJou9t1DpNe1cDk0QL69/EU/neF/mKLRQFsasUcwilUhi6SeU0gW7SCI/2fxCMvZylZVFaADKgTMQOWUelNP72xpK5H0FBaSTcCRj3+BQo82tS5KKkpKIDLQnQgQNuevht1/BoCtjbir/hF+GAFBf4J+UPylzzeZOj/BBgAEMbWQcBVFacAAAAASUVORK5CYII=" width="28px">--}}
{{--                                            <div class="pull-left" style="font-weight: 600;font-size: 12px">Delivery Time</div>--}}
{{--                                            <div class="pull-left" style="color: rgb(233, 30, 99);font-weight: 600;font-size: 11px;">Today !{ timeSlot.start }! - !{ timeSlot.end }!</div>--}}
{{--                                        </div>--}}

{{--                                     </div>--}}
{{--                                </div>--}}
{{--                                </td>--}}
{{--                                @if($order_custumer->transit_date)--}}
{{--                                <td style="border: 1px solid #cccccc54;">TRANSIT Time:<br> <b style="color: #e91e63;">--}}
{{--                                        {{ date('h:i a', strtotime($order_custumer->transit_date)) }}--}}
{{--                                    </b></td>--}}
{{--                                @endif--}}

                            </tr>
                        </table>
                    </div>
                    </div>
                <div class="panel panel-default simple-panel">
                    <div class="panel-heading">
{{--                      @if($order_custumer->transit_date)--}}
{{--                         <span style="color: #e91e63;font-size: 13px;font-weight: bold;text-transform: uppercase;"><span style="color: #000;">TRANSIT Time:</span> {{ date('h:i a', strtotime($order_custumer->transit_date)) }}</span>--}}
{{--                            @endif--}}
                            {{--                        <span>&nbsp;--}}
{{--                              <small>PHONE: <span class="orange-color">{{ $order_custumer->phone }}</span>--}}
{{--                              </small>--}}
{{--                               <small>TRN ID: <span class="orange-color">{{ $order_custumer->transaction_number }}</span></small>--}}
                           </span>
                        <a href="print-en/{{$order_custumer->order_id}}/" target="_blank"
                           class="btn btn-primary btn-sm pull-right">PRINT EN</a>
                        <a href="print/{{$order_custumer->order_id}}/" target="_blank"
                           class="btn btn-primary btn-sm pull-right mr15">PRINT BN</a>
{{--                        <a href="custom-order/{{$order_custumer->order_id}}/" target="_blank"--}}
{{--                           class="btn btn-warning btn-sm pull-right mr15">CUSTOM ORDER</a>--}}
{{--                        <a href="order_buy_price_print/{{$order_custumer->order_id}}/" target="_blank"--}}
{{--                           class="btn btn-default btn-sm pull-right mr15">ADMIN COPY</a>--}}
                        @if(Auth::user()->role != 'author')
{{--                        <button type="button" onclick="update_fields_show()"--}}
{{--                                class="btn btn-default btn-sm pull-right mr15 show_pricing_field"><i--}}
{{--                                    class="fa fa-tag"></i></button>--}}
                        @endif


                    </div>

                    <div class="panel-body">
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif

                        @if(Auth::user()->role === 'admin')
                        {!! Form::open(['url' => 'ad/order/order_status','class'=>'form-vertical','enctype'=>'multipart/form-data','files'=>true ]) !!}
                        @elseif(Auth::user()->role === 'manager')
                        {!! Form::open(['url' => 'pm/order/order_status','class'=>'form-vertical','enctype'=>'multipart/form-data','files'=>true ]) !!}
                        @elseif(Auth::user()->role === 'author')
                        {!! Form::open(['url' => 'au/order/order_status','class'=>'form-vertical','enctype'=>'multipart/form-data','files'=>true ]) !!}

                        @endif


                        {{ csrf_field() }}
                        <input type="hidden" id="cus_phone" name="phone" value="{{$order_custumer->phone}}"/>
                        <input type="hidden" name="order_total"
                               value="{{$order_custumer->order_total + $order_custumer->delivery_charge - $order_custumer->coupon_discount_amount}}"/>

                        <table class="table table-striped table-bordered edit_order_table">
                            <thead>
                            <tr>
                                <td></td>
                                <td>Product Name</td>
                                <td class="text-center">Photo</td>
                                <td class="text-center">Unit Price</td>
                                <td class="text-center">Order.Qty</td>
                                <td> Total</td>
                                <td colspan="2" class="buy_price_th text-center"> Buy Price</td>

                            </tr>
                            </thead>
                            <tbody>

                            @foreach ($order_products  as $order_product)
                            <tr id="product_{{$order_product->product_id}}">
                                @if($order_custumer->active_status>=3)
                                <td></td>
                                @else
                                @if(count($order_products) >1 )
                                <td width="25px"
                                    onclick="openModal({{$order_custumer->order_id }},{{$order_product->product_id}},{{$order_product->quantity}})"
                                    class="text-center removeProduct"
                                    data-orderid="{{$order_custumer->order_id }}"
                                    data-productid="{{$order_product->product_id}}">
                                    <img src="{{ url('/images/error.png') }}" width="25px"/>
                                </td>
                                @else
                                <td></td>
                                @endif

                                @endif

                                <td>
                                    @if($order_product->custom_name_en)
                                    {{$order_product->custom_name_en}}
                                    <input type="hidden" class="name_en"
                                           value="{{$order_product->custom_name_en}}">
                                    <input type="hidden" class="name_bn"
                                           value="{{$order_product->custom_name_bn}}">

                                    @else
                                    <input type="hidden" class="name_en"
                                           value="{{$order_product->name}} {{$order_product->strength}} {{$order_product->unit_quantity}} {{$order_product->unit}}">
                                    <input type="hidden" class="name_bn"
                                           value="{{$order_product->name_bn}} {{$order_product->strength}}  {{$order_product->unit_quantity}} {{$order_product->unit}}">
                                    <div> {{$order_product->name}} {{$order_product->strength}}
                                        {{$order_product->unit_quantity}} <span
                                                style="text-transform: capitalize;">{{$order_product->unit}}</span>
                                    </div>

                                    @endif
                                                                                        @foreach ($customize_products  as $customize_product)
                                                                                            @if($customize_product->product_id == $order_product->product_id)
                                                                                                @if($order_custumer->active_status<3)
{{--                                                                                                    <i class="fa fa-pencil"--}}
{{--                                                                                                       onclick="CustomProductModal({{$order_custumer->order_id }},{{$order_product->product_id}},{{$order_product->quantity}},{{$order_product->unit_price}},{{$order_product->total_price}})"></i>--}}
                                                                                                @endif
                                                                                            @endif
                                                                                        @endforeach
                                </td>
                                <td class="text-center">
                                    <img width="55px"
                                         src="{{ url('/uploads/products') }}/{{$order_product->featured_image}}"/>
                                </td>

                                <td class="text-center product_id_{{$order_product->product_id}}"><span
                                            class="unit_price">{{$order_product->unit_price}}</span></td>
                                <td class="text-center product_id_{{$order_product->product_id}}">
                                    <div class="relative pl_minus">
                                        @if($order_custumer->active_status<3)
                                        {{--                                                                                                        <img onclick="decreaseQty({{$order_product->product_id}},{{$order_custumer->order_id }})" src="https://gopalganjbazar.com/web/images/minus-square.png" class="img inc" width="30px">--}}
                                        @endif
                                        <span class="cart_quantity">{{ $order_product->quantity }}</span>
                                        @if($order_custumer->active_status<3)
                                        {{--                                                                                                    <img onclick="increaseQty({{$order_product->product_id}},{{$order_custumer->order_id }})" src="https://gopalganjbazar.com/web/images/square-plus.png" class="img dec" width="30px"></div>--}}
                                    @endif
                                </td>
                                <td>&#2547;<span
                                            id="totalP_{{$order_product->product_id}}">{{$order_product->total_price}}</span>
                                </td>
                                <td class="buy_price_td" id="p_total_{{$order_product->product_id}}">

                                    @if($order_product->total_buy_price > 0)
                                    &#2547;{{$order_product->total_buy_price}}
                                    @else
                                    &#2547;{{$order_product->buy_price * $order_product->quantity }}
                                    @endif


                                </td>



                                @if($order_product->total_buy_price > 0)
                                @if(Auth::user()->role === 'admin')
                                <td class="buy_price_td">
                                    <input type="text" id="input_{{$order_product->product_id}}"
                                           title="Single Product Buy Price"
                                           value="{{$order_product->total_buy_price / $order_product->quantity }}"
                                           class="form-control singlePrice"
                                           style="width: 76px;padding: 0 3px;"/>
                                </td>
                                @endif
                                @else
                                <td class="buy_price_td">
                                    <input type="text" id="input_{{$order_product->product_id}}"
                                           title="Single Product Buy Price"
                                           value="{{$order_product->buy_price}}"
                                           class="form-control singlePrice"
                                           style="width: 76px;padding: 0 3px;"/>
                                </td>
                                @endif


                                @if($different_days<2)
                                @if($order_product->total_buy_price > 0)
                                @if(Auth::user()->role === 'admin')
                                <td class="buy_price_td">
                                    <button onclick="update_price({{$order_product->order_id}},{{$order_product->product_id}},{{ $order_product->quantity }})"
                                            type="button"
                                            class="btn btn-sm btn-info btn-block update_price">
                                        UPDATE
                                    </button>
                                </td>
                                @endif
                                @else
                                <td class="buy_price_td">
                                    <button onclick="update_price({{$order_product->order_id}},{{$order_product->product_id}},{{ $order_product->quantity }})"
                                            type="button"
                                            class="btn btn-sm btn-warning btn-block update_price">
                                        SAVE
                                    </button>
                                </td>

                                @endif
                                @endif



                            </tr>
                            @endforeach
                            <tr>

                                <td colspan="5">
                                        <span class="pull-left" style="margin-left: 10px;font-size: 12px;text-transform: uppercase;">
                                            ORDER STATUS:
                                             @if($order_custumer->active_status==0)
                                                <span style="color: orange;font-weight: bold;">  Pending</span>
                                            @elseif($order_custumer->active_status==1)
                                                <span style="color: #2196f3;font-weight: bold;"> Approved</span>
                                            @elseif($order_custumer->active_status==2)
                                                <span style="color: orange;font-weight: bold;"> In Transit</span>
                                            @elseif($order_custumer->active_status==3)
                                                <span style="color: green;font-weight: bold;"> Delivered</span>
                                            @elseif($order_custumer->active_status==4)
                                                <span style="color: red;font-weight: bold;"> Cancelled</span>
                                            @endif
                                        </span>

                                    <span class="pull-left" style="margin-left: 10px;font-size: 12px;text-transform: uppercase;">Area: {{ $order_custumer->area }}</span>
{{--                                    <span class="pull-left badge" style="background-color: #d2d2d2 !important; ;color: green;margin-left: 10px;font-size: 12px;text-transform: uppercase;">P: &#2547;{{$profit}}</span>--}}

                                    <span class="pull-right"> Sub Total</span>
                                </td>
                                <td colspan="2">&#2547;{{$order_custumer->order_total}}</td>


                            </tr>
                            <tr>
                                <td colspan="3" class="text-right">
                                    <div class="input-group">
                                        <input type="text" class="form-control" title="Delivery Address"
                                               placeholder="Address" id="d_address"
                                               value="{{ $order_custumer->address }}"/>
                                        @if($order_custumer->active_status!=3)
{{--                                        <div class="input-group-btn">--}}
{{--                                            <button class="btn btn-default"--}}
{{--                                                    onclick="updateShipping({{ $order_custumer->order_id }})"--}}
{{--                                                    type="button">--}}
{{--                                                <i class="fa fa-save"></i>--}}
{{--                                            </button>--}}
{{--                                        </div>--}}
                                        @endif
                                    </div>
                                </td>
                                <td colspan="2" class="text-right"> Delivery Charge</td>
                                <td colspan="2">&#2547;{{ $order_custumer->delivery_charge }}</td>
                            </tr>

                            <tr>

                                <td colspan="3" class="text-right">
                                    <div class="input-group">
                                        <input type="text" class="form-control" title="Customer Name"
                                               placeholder="Customer Name" id="cus_name"
                                               value="{{ $order_custumer->name }}"/>
                                        @if($order_custumer->active_status!=3)
{{--                                        <div class="input-group-btn">--}}
{{--                                            <button class="btn btn-default"--}}
{{--                                                    onclick="updateShipping({{ $order_custumer->order_id }})"--}}
{{--                                                    type="button">--}}
{{--                                                <i class="fa fa-save"></i>--}}
{{--                                            </button>--}}
{{--                                        </div>--}}
                                        @endif
                                    </div>
                                </td>
                                <td colspan="2" class="text-right"> Discount</td>
                                <td colspan="2" class="orange">
                                    &#2547;-{{ $order_custumer->coupon_discount_amount }}</td>
                            </tr>


                            <tr>
                                <td class="text-right" colspan="2">
{{--                                    <div class="input-group">--}}
{{--                                        <input type="number" min="0" class="form-control" title="Jar Collected"--}}
{{--                                               placeholder="Jar Collected" id="jar_collected">--}}
{{--                                        <div class="input-group-btn">--}}
{{--                                            <button class="btn btn-default" onclick="CollectedJar()" type="button">--}}
{{--                                                <i class="fa fa-save"></i>--}}
{{--                                            </button>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                </td>
                                <td colspan="3" class="text-right"> Total</td>
                                <td colspan="2">
                                    &#2547; {{$order_custumer->order_total + $order_custumer->delivery_charge - $order_custumer->coupon_discount_amount}}
                                    <input type="hidden" value="{{$profit}}">
                                </td>

                            </tr>

                            <tr>
                                <input type="hidden" name="delivery_man_id" value="1">
{{--                                <td>D.M</td>--}}
{{--                                <td>--}}
{{--                                 <input type="hidden" name="delivery_man_id" value="1">--}}
{{--                                    <select class="form-control" name="delivery_man_id" required>--}}
{{--                                        <option value="" selected="">Delivery Person</option>--}}
{{--                                        @foreach ($delivery_mans  as $delivery_man)--}}
{{--                                        <option @if($order_custumer->delivery_man_id===$delivery_man->id) selected=""--}}
{{--                                            @endif value="{{$delivery_man->id}}">{{$delivery_man->name}}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                </td>--}}

{{--                                <td colspan="3" class="text-right">--}}
{{--                                    <select class="form-control" name="sms" style="width: 103px;float: left;">--}}
{{--                                        <option selected>SMS NO</option>--}}
{{--                                        <option value="YES">SMS YES</option>--}}

{{--                                    </select>--}}
{{--                                    <span style="position: relative;top: 8px;">Payment Type</span>--}}
{{--                                </td>--}}
                                <td colspan="2">
                                    
                                </td>

                            </tr>


                            <tr>
{{--                                <td colspan="3">--}}
{{--                                    <div class="input-group">--}}
{{--                                        <input type="text" class="form-control" title="Write Your Note"--}}
{{--                                               placeholder="Write Your Note" id="note"--}}
{{--                                               value="{{ $order_custumer->notes }}"/>--}}

{{--                                        <div class="input-group-btn">--}}
{{--                                            <button class="btn btn-default"--}}
{{--                                                    onclick="updateNote({{ $order_custumer->order_id }})"--}}
{{--                                                    type="button">--}}
{{--                                                <i class="fa fa-save"></i>--}}
{{--                                            </button>--}}
{{--                                        </div>--}}

{{--                                    </div>--}}
{{--                                </td>--}}
{{--                                <td colspan="4">--}}

{{--                                    @if($order_custumer->active_status==4)--}}
{{--                                    @elseif($order_custumer->active_status==3)--}}
{{--                                    @else--}}
{{--                                    <a href="#" data-toggle="modal" data-target="#customer_received"--}}
{{--                                       class="btn btn-warning btn-sm pull-right mr15">CUSTOMER RECEIVED--}}
{{--                                        ORDER</a>--}}
{{--                                    @endif--}}
{{--                                </td>--}}


                            </tr>
                            <tr>
                                <td colspan="6"
                                    class="status_show @if($order_custumer->active_status==3) done @elseif($order_custumer->active_status==4) cancel @endif">
                                    <input type="hidden" id="thisorder_id" name="order_id" value="{{ $order_id }}">
                                    <div class="steps-bar">
                                 <span>1<br/>

                                  Order Created
                                 </span>
                                        <span>2<br/>
                                  <label><input type="radio" name="status" value="approve"
                                                @if($order_custumer->approve_status==1) disabled @endif />   Approve Order</label>

                                 </span>
                                        <span>3<br/>
                                  <label><input type="radio" name="status" value="transit"
                                                @if($order_custumer->transit_status==1) disabled @endif />   In Transit</label>


                                 </span>
                                        @if($order_custumer->cancel_status==1)
                                        <span>4<br/>

                                  <label>

                                      <input type="radio" name="status" value="deivered"
                                             @if($order_custumer->delivered_status==1) disabled @endif />
                                      Deliver Successfully

                                  </label>


                                 </span>
                                        @else
                                        <span>4<br/>

                                  <label>
{{--                                         @if($empty_buy_price_count ==0)--}}
                                          <input type="radio" name="status" value="deivered"
                                                 @if($order_custumer->delivered_status==1) disabled @endif />   Deliver Successfully</label>

{{--                                      @else--}}
{{--                                          Add Buy Price to Deliver--}}
{{--                                      @endif--}}


                                 </span>
                                        @endif
                                        @if($order_custumer->delivered_status==1)
                                        <span>5<br/>

                                   <label><input type="radio" name="status" value="cancel"
                                                 @if($order_custumer->cancel_status==1) disabled @endif />   Cancel</label>

                                 </span>
                                        @else
                                        <span>5<br/>

                                   <label><input type="radio" name="status" value="cancel"
                                                 @if($order_custumer->cancel_status==1) disabled @endif />   Cancel</label>

                                 </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                </td>
                                <td colspan="2">

                                    @if($order_custumer->active_status==3)

                                    @elseif($order_custumer->active_status==4)
                                    @else
                                    @if( $get_order_total->get_order_total==$order_custumer->order_total)

                                    <button type="submit" class="btn btn-primary btn-block">Submit</button>
                                    @endif
                                    @endif


                                </td>
                            </tr>
                            <tr>

                            </tr>
                            </tbody>
                        </table>
                        {!! Form::close() !!}

                        @if(Auth::user()->role === 'admin')
                        {!! Form::open(['url' => 'ad/purchase-from-deposit-money','class'=>'form-vertical','enctype'=>'multipart/form-data','files'=>true ]) !!}
                        @endif
                        <input type="hidden" name="order_id" value="{{ $order_custumer->order_id }}">
                        <input type="hidden" name="phone" value="{{ $order_custumer->phone }}">
                        <input type="hidden" name="order_total" value="{{$order_custumer->order_total + $order_custumer->delivery_charge - $order_custumer->coupon_discount_amount}}">

{{--                        <button class="btn  btn-warning btn-sm">PURCHASE FROM DEPOSIT MONEY</button>--}}
                        {!! Form::close() !!}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="customModal" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Custom Product</h4>
            </div>

            <div class="row modal-body custom-sale">
                <input type="hidden" id="pp_id" class="form-control">
                <input type="hidden" id="order_id" class="form-control">
                <input type="hidden" id="old_total_price"/>

                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Custom Product Title (EN):</label>
                        <input type="text" id="custom_name_en" class="form-control">
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Custom Product Title (BN):</label>
                        <input type="text" id="custom_name_bn" class="form-control">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Product Quantity:</label>
                        <input type="number" onchange="calcuateValue()" onkeyup="calcuateValue()" step="any"
                               id="pp_qty" class="form-control">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Unit Price:</label>
                        <input type="number" step="any" onkeyup="calcuateValue()" onchange="calcuateValue()"
                               id="pp_unit_price" class="form-control">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Total:</label>
                        <input type="number" step="any" id="pp_total_price" class="form-control">
                    </div>
                </div>

            </div>
            <div class="modal-footer">

                <button type="button" onclick="updateSingleProduct()" class="btn btn-success btn-block">Update
                </button>
            </div>

        </div>
    </div>
</div>
<div class="modal   fade" id="myModal" role="dialog">
    <div class="modal-dialog" style="max-width: 376px !important;">

        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-body text-center">
                <h4 style="line-height: 28px;">Are You Sure?<br/>You want to remove This Item From cart.</h4>
            </div>
            <div class="modal-footer" style="border: none; text-align: center;">
                <a href="" id="deleteBtn" class="btn btn-danger deleteBtn" data-morder="" data-mproduct=""
                   onclick="orderCustomize()">Delete</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>

    </div>
</div>
<div class="modal   fade" id="customer_received" role="dialog">
    <div class="modal-dialog" style="max-width: 376px !important;">

        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-body text-center">
                <h4 style="line-height: 28px;color: #388e3c;margin-top: 34px;">Are You Sure?<br/>Customer received
                    Order Successfully.</h4>
            </div>
            <div class="modal-footer" style="border: none; text-align: center;">


                @if(Auth::user()->role === 'admin')
                {!! Form::open(['url' => 'ad/order/customer-order-received-status','class'=>'form-vertical','enctype'=>'multipart/form-data','files'=>true ]) !!}
                @elseif(Auth::user()->role === 'manager')
                {!! Form::open(['url' => 'pm/order/customer-order-received-status','class'=>'form-vertical','enctype'=>'multipart/form-data','files'=>true ]) !!}
                @elseif(Auth::user()->role === 'author')
                {!! Form::open(['url' => 'au/order/customer-order-received-status','class'=>'form-vertical','enctype'=>'multipart/form-data','files'=>true ]) !!}

                @endif

                {{ csrf_field() }}
                <input type="hidden" name="order_id" value="{{$order_custumer->order_id }}">
                <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
                <button type="submit" name="yes" class="btn  btn-success">Yes</button>
                {!! Form::close() !!}
            </div>
        </div>

    </div>
</div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.21/dist/vue.js">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.12.0/underscore-min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>
<style>
    .steps-bar span.selected {
        background: #f273a9;
        color: #fff;
        font-weight: normal;
    }

    .steps-bar span.selected label {
        font-weight: normal;
    }
    .eachsl:hover{
        border: 1px solid #E91E63 !important;
    }
</style>
<script type="text/javascript">


    var app = new Vue({
        el: '#apps',
        delimiters: ['!{', '}!'],
        data: {
            delivery_time_slot:null,
            timeSlots:[],
            order_id:null,
            isActiveTime:false
        },
        created: function () {
        },
        methods: {
            AssignTime: function (day,start,end) {

                 // alert(day + ' '+start+' '+end + ' ' + this.order_id);
                axios.get("https://gopalganjbazar.com/web/api/delivery-slot-update/" + this.order_id+'/'+day + ' '+start+' '+end)
                    .then(function (response) {
                        Command: toastr["success"]("Request Completed Successfully");
                        location.reload();
                    })
                    .catch((error) => {
                        Command: toastr["error"]("Something wrong");
                    });
            },
             deliveryLocations: function (order_id) {
                let vm = this;
                 this.isActiveTime = !this.isActiveTime;
                    axios.get("https://gopalganjbazar.com/web/api/delivery-slot/" + order_id)
                        .then(function (response) {
                            // console.log(response.data.delivery_slots);
                            vm.delivery_time_slot  = response.data.delivery_slots;
                            let delivery_time_slot_list  = response.data.delivery_slots;
                            vm.order_id  = response.data.order_id;

                            if(delivery_time_slot_list){
                                let delivery_time_slot_array_list = delivery_time_slot_list.split(',');
                                for (let i = 0; i < delivery_time_slot_array_list.length; i++) {
                                    // console.log(vm.delivery_time_slot[i]);
                                    const timeArray = delivery_time_slot_array_list[i].split("-");
                                    // alert(typeof timeArray);

                                    if (timeArray === undefined || timeArray.length == 0) {
                                    } else {
                                        //present  hour value
                                        let startTime = new Date().getFullYear() + ' '  + timeArray[0];

                                        let endTime = new Date().getFullYear() + ' '  +  timeArray[1];

                                        var d = new Date(startTime);
                                        var amOrPm = (d.getHours() < 12) ? "AM" : "PM";
                                        var hour = (d.getHours() < 12) ? d.getHours() : d.getHours() - 12;
                                        if(hour == 0){
                                            var StartHour = 12 + ':' + d.getMinutes() + ' ' + amOrPm
                                        }else{
                                            var StartHour =hour + ':' + d.getMinutes() + ' ' + amOrPm
                                        }
                                        var d = new Date(endTime);
                                        var amOrPm = (d.getHours() < 12) ? "AM" : "PM";
                                        var hour = (d.getHours() < 12) ? d.getHours() : d.getHours() - 12;
                                        if(hour == 0){
                                            var endHour =12 + ':' + d.getMinutes() + ' ' + amOrPm
                                        }else{
                                            var endHour =hour + ':' + d.getMinutes() + ' ' + amOrPm
                                        }


                                        vm.timeSlots.push({
                                            'start': StartHour,
                                            'end': endHour,
                                        });
                                    }
                                }
                            }
                        })
                        .catch((error) => {

                        });
            }
        }
    });
</script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    let _token = $('meta[name="csrf-token"]').attr('content');

    function CollectedJar() {
        let jar_collected = $("#jar_collected").val();

        let cus_phone = $("#cus_phone").val();
        //console.log(jar_collected + cus_phone)
        $.ajax({
            type: 'POST',
            @if(Auth::user()->role === 'admin')
        url: '/web/ad/updatewaterfromorder',
        @elseif(Auth::user()->role === 'manager')
        url: '/web/pm/updatewaterfromorder',
            {{--                @elseif(Auth::user()->role === 'author')--}}
        {{--                url: '/web/au/updatewaterfromorder',--}}
    @endif
        data: {
            jar_collected: jar_collected,
                cus_phone: cus_phone,
                _token: _token
        },
        success: function (data) {
            console.log(data);
            alert(data);
            if (data.status == 200) {
                //Command: toastr["info"](data.message);
            }
            //location.reload();
        }
    });

    }


    jQuery(".steps-bar span").click(function (event) {
        jQuery(".steps-bar span").removeClass("selected");
        jQuery(this).addClass("selected");
    });


    function calcuateValue() {

        let quantity = $("#pp_qty").val();
        let price = $("#pp_unit_price").val();
        let total = quantity * price;
        $("#pp_total_price").val(total);
    }


    function CustomProductModal(order_id, product_id, order_quantity, unit_price, total_price) {

        $("#customModal").modal();
        $('#pp_id').val(product_id);
        $('#order_id').val(order_id);
        $('#pp_qty').val(order_quantity);
        $('#pp_unit_price').val(unit_price);
        $('#pp_total_price').val(total_price);
        $('#old_total_price').val(total_price);

        let name_bn = $('#product_' + product_id + ' .name_bn').val();
        let name_en = $('#product_' + product_id + ' .name_en').val();

        $('#custom_name_en').val(name_en);
        $('#custom_name_bn').val(name_bn);


    }

    function updateSingleProduct() {
        let product_id = $('#pp_id').val();
        let order_id = $('#order_id').val();
        let order_quantity = $('#pp_qty').val();
        let unit_price = $('#pp_unit_price').val();
        let total_price = $('#pp_total_price').val();
        let custom_name_en = $('#custom_name_en').val();
        let custom_name_bn = $('#custom_name_bn').val();
        let total_buy_price = $('#pp_total_buy_price').val();
        let _token = $('meta[name="csrf-token"]').attr('content');
        let old_total_price = $('#old_total_price').val();

        $.ajax({
            type: 'POST',
            @if(Auth::user()->role === 'admin')
        url: '/web/ad/order/product-customize',
        @elseif(Auth::user()->role === 'manager')
        url: '/web/pm/order/product-customize',
        @elseif(Auth::user()->role === 'author')
        url: '/web/au/order/product-customize',
        @endif
        data: {
            product_id: product_id,
                order_id: order_id,
                order_quantity: order_quantity,
                unit_price: unit_price,
                total_price: total_price,
                custom_name_en: custom_name_en,
                custom_name_bn: custom_name_bn,
                total_buy_price: total_buy_price,
                old_total_price: old_total_price,
                _token: _token
        },
        success: function (data) {
            console.log(data);
            Command: toastr["info"]("Updated Successfully.");
            location.reload();
        }
    });


    }


    function increaseQty(product_id, order_id) {
        var retVal = confirm("Do you want to Increase Quantity");
        if (retVal == true) {
            let product_quantity = $(".product_id_" + product_id + ' .cart_quantity').text();
            let unitPrice = parseInt($(".product_id_" + product_id + ' .unit_price').text());
            let newQty = parseInt(product_quantity) + 1;
            $(".product_id_" + product_id + ' .cart_quantity').text(newQty)
            $.ajax({
                type: 'GET',
                @if(Auth::user()->role === 'admin')
            url: '/web/ad/order/admin-custom-order-product-increase/' + order_id + '/' + product_id + '/' + product_quantity + '/' + newQty + '/' + unitPrice,
            @elseif(Auth::user()->role === 'manager')
            url: '/web/pm/order/admin-custom-order-product-increase/' + order_id + '/' + product_id + '/' + product_quantity + '/' + newQty + '/' + unitPrice,
            @elseif(Auth::user()->role === 'author')
            url: '/web/au/order/admin-custom-order-product-increase/' + order_id + '/' + product_id + '/' + product_quantity + '/' + newQty + '/' + unitPrice,

            @endif
            dataType: "json",
                success: function (data) {
                console.log(data);
                Command: toastr["info"]("New Quantity Updated Successfully.");
                location.reload();
            }
        });
            return true;
        } else {

            return false;
        }

    }


    function decreaseQty(product_id, order_id) {
        var retVal = confirm("Do you want to Decrease Quantity");
        if (retVal == true) {
            let product_quantity = parseInt($(".product_id_" + product_id + ' .cart_quantity').text());
            let unitPrice = parseInt($(".product_id_" + product_id + ' .unit_price').text());

            if (product_quantity > 1) {
                let newQty = product_quantity - 1;
                $(".product_id_" + product_id + ' .cart_quantity').text(newQty)
                $.ajax({
                    type: 'GET',
                    @if(Auth::user()->role === 'admin')
                url: '/web/ad/order/admin-custom-order-product-decrease/' + order_id + '/' + product_id + '/' + product_quantity + '/' + newQty + '/' + unitPrice,
                @elseif(Auth::user()->role === 'manager')
                url: '/web/pm/order/admin-custom-order-product-decrease/' + order_id + '/' + product_id + '/' + product_quantity + '/' + newQty + '/' + unitPrice,
                @elseif(Auth::user()->role === 'author')
                url: '/web/au/order/admin-custom-order-product-decrease/' + order_id + '/' + product_id + '/' + product_quantity + '/' + newQty + '/' + unitPrice,

                @endif
                dataType: "json",
                    success: function (data) {
                    console.log(data);
                    Command: toastr["info"]("New Quantity Updated Successfully.");
                    location.reload();
                }
            });
            }
            return true;
        } else {

            return false;
        }

    }


    function updateShipping(order_id) {
        let address = $("#d_address").val();
        let customer_name = $("#cus_name").val();
        $.ajax({
            type: 'GET',
            @if(Auth::user()->role === 'admin')
        url: '/web/ad/order/update-shipping/' + order_id + '/' + address + '/' + customer_name,
        @elseif(Auth::user()->role === 'manager')
        url: '/web/pm/order/update-shipping/' + order_id + '/' + address + '/' + customer_name,
        @elseif(Auth::user()->role === 'author')
        url: '/web/au/order/update-shipping/' + order_id + '/' + address + '/' + customer_name,
        @endif
        dataType: "json",
            success: function (data) {
            console.log(data);
            Command: toastr["info"]("Shipping Updated Successfully.");
        }
    });

    }

    function updateNote(order_id) {
        let note = $("#note").val();
        if(note == null){
            let note = ' ';
        }
        //alert(note);
        $.ajax({
            type: 'GET',
            @if(Auth::user()->role === 'admin')
        url: '/web/ad/order/update-note/' + order_id + '/' + note,
        @elseif(Auth::user()->role === 'manager')
        url: '/web/pm/order/update-note/' + order_id + '/' + note,
        @elseif(Auth::user()->role === 'author')
        url: '/web/au/order/update-note/' + order_id + '/' + note,
        @endif
        dataType: "json",
            success: function (data) {
            console.log(data);
            Command: toastr["info"]("Note Updated Successfully.");
        }
    });

    }


    function openModal(order_id, product_id, quantity) {

        $("#myModal").modal();

        //$('.deleteBtn').attr('data-mproduct', product_id);
        // $('.deleteBtn').attr('data-morder', order_id);
    @if(Auth::user()->role === 'admin')
        $('#deleteBtn').attr("href", '/web/ad/order/custom-order/' + order_id + '/' + product_id + '/' + quantity);
    @elseif(Auth::user()->role ==='manager')
        $('#deleteBtn').attr("href", '/web/pm/order/custom-order/' + order_id + '/' + product_id + '/' + quantity);
    @elseif(Auth::user()->role ==='author')
        $('#deleteBtn').attr("href", '/web/au/order/custom-order/' + order_id + '/' + product_id + '/' + quantity);
    @endif

    }

    function orderCustomize() {
        var product_id = $('.deleteBtn').attr('data-mproduct');
        var order_id = $('.deleteBtn').attr('data-morder');
        $.ajax({
            type: 'GET',
            @if(Auth::user()->role === 'admin')
        url: '/web/ad/order/custom-order/' + product_id + '/' + order_id,
        @elseif(Auth::user()->role ==='manager')
        url: '/web/pm/order/custom-order/' + product_id + '/' + order_id,
        @elseif(Auth::user()->role ==='author')
        url: '/web/aucustom-order/' + product_id + '/' + order_id,
        @endif
        dataType: "json",
            //data:'_token = <?php //echo csrf_token() ?>',
            data: '_token = <?php echo csrf_token() ?>',
            success: function (data) {
            console.log(data);
        }
    });
    }


</script>
<script>

    //$(".courierinfo").hide();
    // function getval(sel)
    //{
    // if(sel.value==4){  date('Y-m-d', strtotime($order_custumer->created_at)) == date('Y-m-d')

    // $(".courierinfo").show();
    // }else{
    //   $(".courierinfo").hide();
    // }
    //}

    $(".buy_price_td,.buy_price_th").hide();

    function update_fields_show() {
        $(".buy_price_td,.buy_price_th").toggle();
    }

    function update_price(order_id, product_id, order_quantity) {

        var p = $("#input_" + product_id).val();
        if (p > 0) {
            var product_price = p * order_quantity;

            $("#p_total_" + product_id + " span").text(product_price);
            var buyPrice = $("#totalP_" + product_id).text();
            if (buyPrice < product_price) {
                alert("BUY Price Is Bigger Than Sell Price. BUY PRICE:" + product_price + " SELL PRICE:" + buyPrice);
            }
            $.ajax({
                type: 'GET',
                @if(Auth::user()->role === 'admin')
            url: '/web/ad/order-product-buy-price-update/' + order_id + '/' + product_id + '/' + product_price,
            @elseif(Auth::user()->role === 'manager')
            url: '/web/pm/order-product-buy-price-update/' + order_id + '/' + product_id + '/' + product_price,
            @endif
            dataType: "json",
                success: function (data) {
                console.log(data);
                Command: toastr["info"]("Buy Price Updated Successfully.");
            }
        });
        } else {
            alert('Input Product Buy Price');
        }


    }


</script>

@endsection
