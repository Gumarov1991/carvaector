<style>
    .my-3 {
        margin: 1rem 0 1rem 0;
    }
    .m-3 {
        margin: 1rem;
    }
    .row>div { display: inline-block; }
    .w450p { width: 300px; margin: 15px; padding: 15px; border: 1px solid gray; border-radius: 10px; }
</style>
    
    <form action="./admin.php?content&lang_id={$lang_id}&id={$id}" method="post" ENCTYPE="multipart/form-data">
        <input type="hidden" name="save" value="yes">
           <div class="row">
        {foreach item = row from = $hot_list key=i}
               <div class="w450p">
                    <input type="hidden" name="n{$i}" value="{$row.id}">
                    <div class="my-3">
                        <h3><b>Hott off ID: {$row.id}</b></h3>
                    </div>
                    <div class="my-3">
                        <img src="{if $row.photo}./get_image.php?w=155&h=107&pic={$row.photo}&{$row.dt}{else}./pics/no_foto.gif{/if}" width="155" height="107" alt="{$row.name}">
                    </div>
                    <div class="my-3">
                        <label>Name</label>
                        <input name="name{$i}" style="width:250px;" value="{$row.name}">
                    </div>
                    <div class="my-3">
                        <label>Make</label>
                        <input name="mark{$i}" style="width:250px;" value="{$row.mark}">
                    </div>
                    <div class="my-3">
                        <label>Model</label>
                        <input name="model{$i}" style="width:250px;" value="{$row.model}">
                    </div>
                    <div class="my-3">
                        <label>Year</label>
                        <input name="year{$i}" style="width:250px;" value="{$row.year}">
                    </div>
                    <div class="my-3">
                        <label>Engine</label>
                        <input name="engine{$i}" style="width:250px;" value="{$row.engine}">
                    </div>
                    <div class="my-3">
                        <label>Chassis</label>
                        <input name="chassis{$i}" style="width:250px;" value="{$row.chassis}">
                    </div>
                    <div class="my-3">
                        <label>Milleage</label>
                        <input name="mileage{$i}" style="width:250px;" value="{$row.mileage}">
                    </div>
                    <div class="my-3">
                        <label>Transmission</label>
                        <input name="transmission{$i}" style="width:250px;" value="{$row.transmission}">
                    </div>
                    <div class="my-3">
                        <label>Fuel</label>
                        <input name="fuel{$i}" style="width:250px;" value="{$row.fuel}">
                    </div>
                    <div class="my-3">
                        <label>Colour</label>
                        <input name="color{$i}" style="width:250px;" value="{$row.color}">
                    </div>
                    <div class="my-3">
                        <label>Delivery</label>
                        <input name="delivery{$i}" style="width:250px;" value="{$row.delivery}">
                    </div>
                    <div class="my-3">
                        <label>Description</label>
                        <textarea name=note{$i} style="width:300px;height:100px;margin-right:10px;">
                            {$row.note}
                        </textarea>
                    </div>
                    <div class="my-3">
                        <label>Price</label>
                        <input name="amount{$i}" style="width:250px;" value="{$row.amount}">
                    </div>
                    <div class="my-3">
                        <label>Photo</label>
                        <input type="file" name="fn{$i}" style="width:250px;">
                    </div>
                    <div class="m-3">
                        <input type="image" src="./pics/admin-save.gif" width="107" height="20">
                    </div>
               </div>
        {/foreach}
           </div>
    </form>
