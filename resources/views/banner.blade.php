<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-4-grid@3.4.0/css/grid.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css">
<link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;900&display=swap" rel="stylesheet">

{{--
<div style="font-family: 'Alata', sans-serif; width: 780px; height: 160px; background-image: url('./banner-bg.png'); background-size: 100% auto; color: #fff;">
--}}
<body style="background: #000; margin: 0; padding: 0">

<div style="font-family: 'Source Sans Pro', sans-serif; width: 800px; height: 240px; background-position: bottom; color: #fff;">
    <div style="padding: 0px ">

        <div class="row no-gutters">

            <div class="col-md-4 p-0 text-right " style=" height: 240px; background-repeat: no-repeat; background-image: url('https://www.realitymod.com/mapgallery/images/maps/{{ \Illuminate\Support\Str::slug(str_replace(' ','',$mapname)) }}/mapoverview_{{ $gametype }}_{{ $mapsize }}.jpg'); background-size: 100% auto ; background-position: center">
            </div>
            <div class="col-md-8"
                 style="background-image: url(' https://www.realitymod.com/mapgallery/images/maps/{{ str_replace(' ','',strtolower($mapname)) }}/banner.jpg'); background-size:auto 100% ; ">
{{--
                <div style="padding: 20px; background: #3e1b079e;">
                    <h4 style="margin: 0; padding: 0; text-transform: uppercase;"> {{ $hostname }}</h4>
                </div>
--}}

                <div style="padding: 35px 40px">
                    <h3 style="margin: 0; padding: 0; text-transform: uppercase;"> {{ $hostname }}</h3>
                    <div class="pt-3" >
                    @if((str_replace(['gpm_'],'',$gametype) )=="cq")
                        AAS
                    @elseif((str_replace(['gpm_'],'',$gametype) )=="vehicles")
                        Vehicle Warfare
                    @else
                        {{ ucfirst(str_replace(['gpm_'],'',$gametype) ) }}
                    @endif
                    </div>

                    <h1 style="margin: 0; padding: 0; text-transform: uppercase">{{ $mapname }}</h1>
                    <h2 style="margin: 0; padding: 0; font-size: 50px; margin-top: -10px;font-weight: 400">{{ $numplayers }} <span style="font-weight: 800">/ {{ $maxplayers }}</span></h2>
                </div>
            </div>

        </div>
    </div>

    <div>

    </div>

</div>
</body>
