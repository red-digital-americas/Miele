require.config({
    baseUrl: '../',
    paths : {
      jquery : 'apis/jquery-3.1.1.min',
      bootstrapjs: 'apis/bootstrap/js/bootstrap.min',
      login: 'js/login'
  },
  shim : {
          jquery : {
      exports : 'jQuery'
    },
   "bootstrapjs" : { "deps" :['jquery'] }
  }
});
