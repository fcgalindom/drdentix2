<template>
       <footer class="bg-principal text-center text-white ">
        <div class="container p-3 ">
            <div class="row ">
                <div class="col-12 col-sm-12 col-md-4 col-lg-5 my-3 d-flex flex-column text-md-start ">
                    <h5>Terminos y condiciones</h5>
                    <span class="mb-2 ">Politicas de privacidad</span>
                    <span class="mb-2 ">Terminos y condiciones</span>
                    <span class="mb-2 ">Ayuda</span>
                </div>
                <div class="col-12 col-sm-12 col-md-4 col-lg-5 d-flex flex-column text-md-start my-3 ">
                    <h5>Información de contacto</h5>
                    <span class="mb-2 ">(+57) 315 654 9290</span>
                    <span class="mb-2 ">Dr.Dentix@hotmail.com</span>
                </div>
                <div class="col-12 col-sm-12 col-md-4 col-lg-2 my-3 my-md-2 d-flex flex-column justify-content-end ">
                    <img src="../../Img/logo.png" alt=" ">
                    <div>
                        <a class=" btn btn-transparent text-white shadow-none " :href="facebook" target="_blank " role="button ">
                            <font-awesome-icon class="fa-lg" icon="fa-brands fa-facebook" />
                            <!-- <i class="fab fa-facebook-f fa-lg"></i> -->
                        </a>
                        <a class="btn btn-transparent text-white shadow-none " :href="whatsapp" target="_blank " role="button ">
                            <!-- <i class="fab fa-whatsapp "></i> -->
                            <font-awesome-icon class="fa-lg" icon="fa-brands fa-whatsapp" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</template>
<script>
export default {
    data(){
        return{
            facebook: 'https://www.facebook.com/Dr.Dentix/',
            whatsapp: 'https://api.whatsapp.com/send?phone=573156549290&text=Hola Dr. Dentix, me gustaría obtener más información',
        }
    }
}
</script>
<style>
    .bg-blue {
        background-color: #00AFF1;
    }

    .bg-pink {
        background-color: #FF3366;
        border: 1px solid #FF3366;
    }

    .bg-pink::placeholder {
        color: white;
    }

    .bg-pink:focus {
        background-color: #FF3366;
        border: 1px solid #FF3366;
        color: white;
    }

    .text-gray {
        color: #9FA4A7;
    }

    .bg-principal {
        background-color: #013253;
    }

    .color-principal {
        color: #013253 !important;
    }

    .text-md-start > h5{
        color: #fff;
    }
    .text-md-start span{
        color: #fff;
    }

</style>
