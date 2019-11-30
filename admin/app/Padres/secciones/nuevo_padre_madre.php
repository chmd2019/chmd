<div class="row">
    <div class="card col-sm-12 col-md-6 border panel-personalizado">
        <div class="card-body">
            <h6 class="text-primary border-bottom">
                <i class="material-icons">person_add</i>&nbsp;&nbsp;NUEVO PADRE/MADRE
            </h6>
            <br>
            <form id="post_nuevo_padres"
                  action="/pruebascd/admin/app/Padres/common/post_nuevo_padres.php" 
                  class="needs-validation post_nuevo_padres" novalidate>
                <div class="form-row">
                    <div class="col-md-12">
                        <label for="nombre">Nombre</label>
                        <input type="text" 
                               class="form-control text-uppercase"
                               name="nombre"
                               placeholder="Introduce el nombre del padre o madre" 
                               autocomplete="off"
                               autofocus
                               required>
                        <span class="invalid-feedback">¡Dato inválido!</span>
                        <br>
                    </div>
                    <div class="col-md-12">
                        <label for="apellidos">Apellidos</label>
                        <input type="text" 
                               class="form-control text-uppercase"
                               name="apellidos"
                               placeholder="Introduce los apellidos" 
                               autocomplete="off"
                               required>
                        <span class="invalid-feedback">¡Dato inválido!</span>
                        <br>
                    </div>
                    <div class="col-md-12">
                        <label for="rol">Rol</label>
                        <select class="custom-select text-uppercase" name="rol">
                            <option disabled>Seleccione rol</option>
                            <option value="Padre">Padre</option>
                            <option value="Madre">Madre</option>
                        </select>
                        <br>
                        <br>
                    </div>
                    <div class="col-md-12">
                        <label for="email">e-mail</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupPrepend">@</span>
                            </div>
                            <input type="text" 
                                   class="email form-control" 
                                   placeholder="Email" 
                                   placeholder="Introduce e-mail" 
                                   name="email"
                                   autocomplete="off"
                                   aria-describedby="inputGroupPrepend" 
                                   pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" 
                                   required>
                            <div class="invalid-feedback">
                                ¡Dato inválido!
                            </div>
                        </div>
                        <br>
                    </div>
                    <div class="col-md-12">
                        <label for="rol">Familia</label>
                        <p></p>
                        <select class="selectpicker border rounded-lg"  
                                data-live-search="true"
                                name="familia">
                                    <?php foreach ($familias as $value) : ?>
                                <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">¡Seleccione una familia!</div>
                    </div>
                    <br>
                    <br>
                    <br>
                </div>
                <span class="col-md-12"><hr></span>
                <button class="btn btn-primary" type="submit">Guardar</button>
            </form>
        </div>
    </div>
</div>

<script>

    (function () {
        'use strict';
        window.addEventListener('load', function () {
            var forms = document.getElementsByClassName('post_nuevo_padres');
            var validation = Array.prototype.filter.call(forms, function (form) {
                form.addEventListener('submit', function (event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    } else {
                        event.preventDefault();
                        var data = $("#post_nuevo_padres").serialize();
                        $.ajax({
                            url: $("#post_nuevo_padres").attr('action'),
                            beforeSend: () => {
                                spinnerIn();
                            },
                            type: 'POST',
                            dataType: 'json',
                            data: data
                        }).done((res) => {
                            if (res) {
                                success_alerta('Solicitud realizada con éxito');
                                setInterval(() => {
                                    window.location.reload()
                                }, 2000);
                            } else {
                                fail_alerta('No fué posible realizar su solicitud');
                            }
                        }).fail(() => {
                            fail_alerta('No fué posible realizar su solicitud');
                        }).always(() => {
                            spinnerOut();
                        });
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>