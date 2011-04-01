window.addEvent('domready', function() {
    var element = document.id('pygfs-ui-container');
    element.getElements('.oac-input').addEvent('change', function() {
        var target = element.getElementById('oac-output-panel'),
            fid = element.getElementById('forecast').get('value'),
            tid = element.getElementById('type').get('value'),
            imgid = 'http://origin.cpc.ncep.noaa.gov/products/JAWF_Monitoring/GFS/Paraguay_curr.p.gfs'+fid+''+tid+'.gif',
            el = Asset.image(imgid, {onLoad: function() { target.empty(); target.adopt(this); }});
    });
    element.getElementById('forecast').fireEvent('change');
});