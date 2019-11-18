<style>
    .card-style {
        /*height: 100%;*/
        border: 1px solid #DDD;
        -webkit-box-shadow: 3px 5px 30px 3px rgba(0, 0, 0, 0.3);
        -moz-box-shadow: 3px 5px 30px 3px rgba(0, 0, 0, 0.3);
        -o-box-shadow: 3px 5px 30px 3px rgba(0, 0, 0, 0.3);
        box-shadow: 3px 5px 30px 3px rgba(0, 0, 0, 0.3);
    }

    .card-style p {
        margin: 5px 0;
    }

    #breadcrumb {
        margin: 10px;
    }

    section {
        padding: 5px !important;
    }

    .f-bold {
        font-weight: 700;
    }
</style>

<section id="breadcrumb">
    <div class="container">
        <div class="row">
            <a href="/index.php" class="nav">{$content_2}</a>
            <span class="mx-1">></span>
            <a href="/index.php?hotpr" class="nav"><span class="nav"> {$content_13} </span></a>
            {if $issingle}
                <span class="mx-1">></span>
                <span class="nav"> {$hotpr_data.name} </span>
            {/if}
        </div>
    </div>
</section>

<section id="hotoff" class="my-3">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12" style="">
                <p style="font-size:16px;padding-left: 15px;font-family:arial,helvetica,sans-serif;margin-bottom:0.5rem;"
                >
                    {$content_502}
                </p>
                <p style="padding-left: 15px;font-family:arial,helvetica,sans-serif;"
                >
                    <a href="/index.php?catalog" style="font-size:16px;">{$content_4}</a>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12"><p style="font-size:14px;padding-left: 15px;">{$content_501}</p></div>
        </div>
        <div class="row">
            {if !$issingle}
                {foreach item = row from = $hotpr}
                    <div class="col-lg-3 my-3" onclick="window.location='./index.php?hotpr=1&prid={$row.id}';" style="cursor: pointer;">
                        <div class="card-style p-3">
                            <!-- <h4 class="my-3">{$row.name}</h4> -->
                            <img width="100%" src="{if $row.photo}./get_image.php?w=226&h=168&pic={$row.photo}&{$row.dt}{else}./pics/no_foto.gif{/if}" alt="{$row.name}" style="object-fit: cover;">
                            <p class="text-">
                                <span class="f-bold">{$content_460}:</span>
                                {$row.mark}
                            </p>
                            <p class="text-">
                                <span class="f-bold">{$content_461}:</span>
                                {$row.model}
                            </p>
                            <p class="text-">
                                <span class="f-bold">{$content_462}:</span>
                                {$row.year}
                            </p>
                            <p class="text-">
                                <span class="f-bold">{$content_463}:</span>
                                {$row.engine}
                            </p>
                            <p class="text-">
                                <span class="f-bold">{$content_464}:</span>
                                {$row.chassis}
                            </p>
                            <p class="text-">
                                <span class="f-bold">{$content_467}:</span>
                                {$row.mileage}
                            </p>
                            <p class="text-">
                                <span class="f-bold">{$content_466}:</span>
                                {$row.transmission}
                            </p>
                            <p class="text-">
                                <span class="f-bold">{$content_468}:</span>
                                {$row.fuel}
                            </p>
                            <p class="text-">
                                <span class="f-bold">{$content_465}:</span>
                                {$row.color}
                            </p>
                            <!-- <p class="text-">
								<span class="f-bold">Description:</span>
								{$row.note|nl2br}
							</p> -->
                            <p class="text-danger">
                                <span class="f-bold">{$content_471}: </span>
                                <span class="text-danger"> {$row.amount} </span>
                            </p>
                            <button class="btn px-5 btn-success">{$content_317}</button>
                        </div>
                    </div>
                {/foreach}
            {else}
                {include file="hotpr_single.tpl"}
            {/if}
        </div>
    </div>
</section>


