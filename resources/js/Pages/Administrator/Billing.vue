<template>
    <section class="home-section">
        <top />
        <div class="container table-responsive text-center">
            <table class="table text-gray">
                <thead class="bg-blue text-white">
                    <tr>
                        <th>nombre del dentista</th>
                        <th>nombre del procedimiento</th>
                        <th>nombre de la sucursal</th>
                        <th>valor que se pagó</th>
                        <th> dia </th>
                        <th> hora </th>
                        <th>Descargar</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(i, index) in patients" :key="index">
                        <td>{{ i?.denpro.dentists.name }}</td>
                        <td>{{ i?.denpro.procedures.name }}</td>
                        <td>{{ i?.dbraches.name }}</td>
                        <td>{{ $parseVillegas(i?.pay) }}</td>
                        <td>{{ i?.day }}</td>
                        <td>{{ i?.hour }}</td>
                        <td>
                            <button type="button" class="btn btn-danger shadow-none" @click="download_pdf(i)">
                                <i class="fas fa-file-pdf"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <foot />
    </section>
</template>



<script>
import top from "@/Layouts/Administrator/Top.vue";
import foot from "@/Layouts/Administrator/Foot.vue";
import pagination from "@/Layouts/Paginator.vue";
export default {
    props: ["patients"],
    data() {
        return {
            patient: {
                id: 0,
                name: "",
                document: "",
                email: "",
                city: "",
                telephone: "",
            },
            title: ''
        };
    },
    created() {
    },
    methods: {
        download_pdf(i) {
            window.open('/Pacientes/download_pdf?key=' + i.patientsF)
        },
    },
    components: {
        top,
        foot,
        pagination,
    },
};
</script>
<style lang="css">
.form-check-input:checked {
    background-color: #01c001;
    border-color: #01c001;
}
</style>
