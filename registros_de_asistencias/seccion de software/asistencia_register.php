<?php
?>
<?php
include_once "header.php";
include_once "nav.php";
?>
<div class="row" id="app">
    <div class="col-12">
        <h1 class="text-center">Asistencias</h1>
    </div>
    <div class="col-12">
        <div class="form-inline mb-2">
            <label for="fecha">Fecha: &nbsp;</label>
            <input @change="refreshAlumnosList" v-model="fecha" name="fecha" id="fecha" type="date" class="form-control">
            <button @click="save" class="btn btn-success ml-2">Guardar</button>
        </div>
    </div>
    <div class="col-12">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>
                            Alumno
                        </th>
                        <th>
                            Estado
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="alumno in alumnos">
                        <td>{{alumno.nombre}}</td>
                        <td>
                            <select v-model="alumno.status" class="form-control">
                                <option disabled value="unset">--Select--</option>
                                <option value="presente">Presente</option>
                                <option value="ausente">Ausente</option>
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="js/vue.min.js"></script>
<script src="js/vue-toasted.min.js"></script>
<script>
    Vue.use(Toasted);
    const UNSET_STATUS = "unset";
    new Vue({
        el: "#app",
        data: () => ({
            alumnos: [],
            fecha: "",
        }),
        async mounted() {
            this.fecha = this.getTodaysDate();
            await this.refreshAlumnosList();
        },
        methods: {
            getTodaysDate() {
                const fecha = new Date();
                const mes = fecha.getMonth() + 1;
                const dia = fecha.getDate();
                return `${fecha.getFullYear()}-${(mes < 10 ? '0' : '').concat(mes)}-${(dia < 10 ? '0' : '').concat(dia)}`;
            },
            async save() {
                // We only need id and status, nothing more
                let alumnosAsignados = this.alumnos.map(alumno => {
                    return {
                        id: alumno.id,
                        status: alumno.status,
                    }
                });
                // And we need only where status is set
                alumnosAsignados = alumnosAsignados.filter(alumno => alumno.status != UNSET_STATUS);
                const cargaUtil = {
                    fecha: this.fecha,
                    alumnos: alumnosAsignados,
                };
                const respuesta = await fetch("./save_asistencia_data.php", {
                    method: "POST",
                    body: JSON.stringify(cargaUtil),
                });
                this.$toasted.show("Guardado", {
                    position: "top-left",
                    duration: 1000,
                });
            },
            async refreshAlumnosList() {
                // Get all employees
                let respuesta = await fetch("./get_alumnos_ajax.php");
                let alumnos = await respuesta.json();
                // Set default status: unset
                let DiccionarioAlumnos = {};
                alumnos = alumnos.map((alumno, index) => {
                    DiccionarioAlumnos[alumno.id] = index;
                    return {
                        id: alumno.id,
                        nombre: alumno.nombre,
                        status: UNSET_STATUS,
                    }
                });
                // Get attendance data, if any
                respuesta = await fetch(`./get_asistencia_data_ajax.php?date=${this.fecha}`);
                let datos_asistencia = await respuesta.json();
                // Refresh attendance data in each employee, if any
                datos_asistencia.forEach(detalle_asistencia => {
                    let alumnoId = detalle_asistencia.alumno_id;
                    if (alumnoId in DiccionarioAlumnos) {
                        let index = DiccionarioAlumnos[alumnoId];
                        alumnos[index].status = detalle_asistencia.status;
                    }
                });
                // Let Vue do its magic ;)
                this.alumnos = alumnos;
            }
        },
    });
</script>
<?php
include_once "footer.php";
