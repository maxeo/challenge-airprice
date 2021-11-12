<template>
  <div class="over-wrapper">

    <div class="wrapper">
      <div class="circle"></div>
      <div class="circle"></div>
      <div class="circle"></div>
      <div class="shadow"></div>
      <div class="shadow"></div>
      <div class="shadow"></div>
    </div>

    <!--    <i class="fal fa-hourglass"></i>-->
  </div>
</template>

<script>
export default {
  name: "Loader"
}
</script>

<style scoped>
i{
  font-size: 72px;



  background: linear-gradient(180deg, #d2cd7f,#222e3c,#d2cd7f, #222e3c, #d2cd7f,#222e3c);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-size: 600% 600%;
  transform: rotate(-20deg);

  -webkit-animation: AnimationName 2.5s ease infinite;
  -moz-animation: AnimationName 2.5s ease infinite;
  -o-animation: AnimationName 2.5s ease infinite;
  animation: AnimationName 2.5s ease infinite;
}

@-webkit-keyframes AnimationName {
  0%{background-position:51% 0%;transform: rotate(-20deg);}
  50%{background-position:50% 100%;transform: rotate(380deg);}
  100%{background-position:51% 0%;transform: rotate(-20deg);}
}
@-moz-keyframes AnimationName {
  0%{background-position:51% 0%;transform: rotate(-20deg);}
  50%{background-position:50% 100%;transform: rotate(380deg);}
  100%{background-position:51% 0%;transform: rotate(-20deg);}
}
@-o-keyframes AnimationName {
  0%{background-position:51% 0%;transform: rotate(-20deg);}
  50%{background-position:50% 100%;transform: rotate(380deg);}
  100%{background-position:51% 0%;transform: rotate(-20deg);}
}
@keyframes AnimationName {
  0%{background-position:51% 0%;transform: rotate(-20deg);}
  50%{background-position:50% 100%;transform: rotate(380deg);}
  100%{background-position:51% 0%;transform: rotate(-20deg);}
}


.over-wrapper{
  position: fixed;
  background: rgba(0, 0, 0, 0.5);
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  z-index: 10001;
}

.wrapper{
  width:200px;
  height:60px;
  position: absolute;
  left:50%;
  top:50%;
  transform: translate(-50%, -50%);
  background: transparent;
}


.circle{
  width:20px;
  height:20px;
  position: absolute;
  border-radius: 50%;
  background-color: #034ea2;
  left:15%;
  transform-origin: 50%;
  animation: circle .5s alternate infinite ease;
}

@keyframes circle{
  0%{
    top:60px;
    height:5px;
    border-radius: 50px 50px 25px 25px;
    transform: scaleX(1.7);
  }
  40%{
    height:20px;
    border-radius: 50%;
    transform: scaleX(1);
  }
  100%{
    top:0%;
  }
}
.circle:nth-child(2){
  left:45%;
  animation-delay: .2s;
}
.circle:nth-child(3){
  left:auto;
  right:15%;
  animation-delay: .3s;
}
.shadow{
  width:20px;
  height:4px;
  border-radius: 50%;
  background-color: rgba(0,0,0,.5);
  position: absolute;
  top:62px;
  transform-origin: 50%;
  z-index: -1;
  left:15%;
  filter: blur(1px);
  animation: shadow .5s alternate infinite ease;
}

@keyframes shadow{
  0%{
    transform: scaleX(1.5);
  }
  40%{
    transform: scaleX(1);
    opacity: .7;
  }
  100%{
    transform: scaleX(.2);
    opacity: .4;
  }
}
.shadow:nth-child(4){
  left: 45%;
  animation-delay: .2s
}
.shadow:nth-child(5){
  left:auto;
  right:15%;
  animation-delay: .3s;
}






</style>