<div class="spinner-background" id="spinner">
    <div class="spinner">
        <img src="/pruebascd/admin/img/spinner.svg" style="width: 60%;">
    </div>
</div>

<style>
    .spinner-background{ 
        display: block;
        width: 100vw;
        height: 100vh;
        background: rgba(255,255,255, .9);
        z-index: 9900;
        position: fixed;
        overflow-y: hidden;
    }
    .spinner{
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        -webkit-transform: translate(-50%, -50%);    
    }
</style>