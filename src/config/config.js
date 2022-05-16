let Path = 'https://geohydrate-bg.000webhostapp.com/api';
if (sessionStorage.getItem("lang")==="en"){
   Path=Path+"/en";
}
module.exports = {
   Path
};