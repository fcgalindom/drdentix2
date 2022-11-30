<template>
  <div>

      <navegador />

    <div class="container-fluid py-5 bg-gray">
      <div class="container">
        <div class="row">
          <div class="h3 text-center mb-4 home-title">
            ¿Por qué elegir Dr.Dentix
          </div>
          <div class="row">
            <div class="col-12 col-md-4 mb-4">
              <h5 class="mb-2 sub-title">
                <button class="icons-a">
                  <i class="fa-solid fa-user-doctor"></i>
                </button>
                Profesionales calificados
              </h5>
              <div class="text-sm-start text-center">
                Lorem ipsum dolor sit, amet consectetur adipisicing elit. Modi
                pariatur delectus quas, aliquid quibusdam fuga magnam illum
                dignissimos libero quidem repellendus, ducimus soluta minus.
                Beatae, illum aspernatur! Asperiores, nostrum a!
              </div>
            </div>
            <div class="col-12 col-md-4 mb-4">
              <h5 class="mb-2 sub-title">
                <button class="icons-a">
                  <i class="fa-solid fa-people-group"></i>
                </button>
                Trabajo en equipo
              </h5>
              <div class="text-sm-start text-center">
                Lorem ipsum dolor sit, amet consectetur adipisicing elit. Modi
                pariatur delectus quas, aliquid quibusdam fuga magnam illum
                dignissimos libero quidem repellendus, ducimus soluta minus.
                Beatae, illum aspernatur! Asperiores, nostrum a!
              </div>
            </div>
            <div class="col-12 col-md-4 mb-4">
              <h5 class="mb-2 sub-title">
                <button class="icons-a">
                  <i class="fa-solid fa-handshake"></i>
                </button>
                Confiabilidad
              </h5>
              <div class="text-sm-start text-center">
                Lorem ipsum dolor sit, amet consectetur adipisicing elit. Modi
                pariatur delectus quas, aliquid quibusdam fuga magnam illum
                dignissimos libero quidem repellendus, ducimus soluta minus.
                Beatae, illum aspernatur! Asperiores, nostrum a!
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12 col-md-4 mb-4">
              <h5 class="mb-2 sub-title">
                <button class="icons-a">
                  <i class="fa-solid fa-medal"></i>
                </button>
                Excelentes resultados
              </h5>
              <div class="text-sm-start text-center">
                Lorem ipsum dolor sit, amet consectetur adipisicing elit. Modi
                pariatur delectus quas, aliquid quibusdam fuga magnam illum
                dignissimos libero quidem repellendus, ducimus soluta minus.
                Beatae, illum aspernatur! Asperiores, nostrum a!
              </div>
            </div>
            <div class="col-4 col-md-4 mb-3"></div>
            <div class="col-12 col-md-4">
              <h5 class="mb-2 sub-title">
                <button class="icons-a">
                  <i class="fa-solid fa-hand-holding-heart"></i>
                </button>
                Buen trato
              </h5>
              <div class="text-sm-start text-center">
                Lorem ipsum dolor sit, amet consectetur adipisicing elit. Modi
                pariatur delectus quas, aliquid quibusdam fuga magnam illum
                dignissimos libero quidem repellendus, ducimus soluta minus.
                Beatae, illum aspernatur! Asperiores, nostrum a!
              </div>
            </div>
          </div>
          <div class="py-4"></div>
        </div>
      </div>

      <div class="container py-5">
        <h2 class="our circle-2 text-center">
          <button class="circle">
            <i class="fa-solid fa-circle"></i>
          </button>
          NUESTROS PROCEDIMIENTOS
        </h2>
      </div>

      <div class="container text-center my-3">
        <div class="row mx-auto my-auto justify-content-center">
          <div
            id="recipeCarousel"
            class="carousel slide"
            data-bs-ride="carousel"
          >
            <div class="carousel-inner" role="listbox">
              <div class="carousel-item active">
                <div class="col-md-3">
                  <div class="card">
                    <div class="card-img">
                      <img :src="carrousel" class="img-fluid" />
                    </div>
                    <div class="card-img-overlay"></div>
                  </div>
                  <h5 class="our">Procedimiento 1</h5>
                </div>
              </div>

              <div class="carousel-item">
                <div class="col-md-3">
                  <div class="card">
                    <div class="card-img">
                      <img :src="carrousel" class="img-fluid" />
                    </div>
                    <div class="card-img-overlay"></div>
                  </div>
                  <h5 class="our">Procedimiento 2</h5>
                </div>
              </div>

              <div class="carousel-item">
                <div class="col-md-3">
                  <div class="card">
                    <div class="card-img">
                      <img :src="carrousel" class="img-fluid" />
                    </div>
                    <div class="card-img-overlay"></div>
                  </div>
                  <h5 class="our">Procedimiento 3</h5>
                </div>
              </div>

              <div class="carousel-item">
                <div class="col-md-3">
                  <div class="card">
                    <div class="card-img">
                      <img :src="carrousel" class="img-fluid" />
                    </div>
                    <div class="card-img-overlay"></div>
                  </div>
                  <h5 class="our">Procedimiento 4</h5>
                </div>
              </div>

              <div class="carousel-item">
                <div class="col-md-3">
                  <div class="card">
                    <div class="card-img">
                      <img :src="carrousel" class="img-fluid" />
                    </div>
                    <div class="card-img-overlay"></div>
                  </div>
                  <h5 class="our">Procedimiento 5</h5>
                </div>
              </div>

              <div class="carousel-item">
                <div class="col-md-3">
                  <div class="card">
                    <div class="card-img">
                      <img :src="carrousel" class="img-fluid" />
                    </div>
                    <div class="card-img-overlay"></div>
                  </div>
                  <h5 class="our">Procedimiento 6</h5>
                </div>
              </div>
            </div>

            <a
              class="carousel-control-prev bg-transparent w-aut"
              href="#recipeCarousel"
              role="button"
              data-bs-slide="prev"
            >
              <span
                class="carousel-control-prev-icon"
                aria-hidden="true"
              ></span>
            </a>
            <a
              class="carousel-control-next bg-transparent w-aut"
              href="#recipeCarousel"
              role="button"
              data-bs-slide="next"
            >
              <span
                class="carousel-control-next-icon"
                aria-hidden="true"
              ></span>
            </a>
          </div>
        </div>
      </div>
    </div>

    <foot />
  </div>
</template>

<script>
import navegador from './components/Navegacion.vue'
import foot from '../../Layouts/Administrator/Foot.vue'
export default {
    props:["carrousel"],
    components: {
        navegador,
        foot
    },
    created(){
        // alert('1')
        let items = document.querySelectorAll('.carousel .carousel-item')
        // alert('2')

        items.forEach((el) => {
            const minPerSlide = 4
            let next = el.nextElementSibling
            for (var i = 1; i < minPerSlide; i++) {
                if (!next) {
                    // wrap carousel by using first child
                    next = items[0]
                }
                let cloneChild = next.cloneNode(true)
                el.appendChild(cloneChild.children[0])
                next = next.nextElementSibling
            }
        })

    }
};
</script>
