function ValueChanged (_id, _valname, _val, _max) 
{
    if (_max !== 'text')
    {
        console.log('text');
        _val = _val.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');
        
        if (parseInt(_val) > parseInt(_max)) 
            _val = _max;
        else if (parseInt(_val) < 0) 
            _val = '0';
    }

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "includes/characterssheet.inc.php", true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onreadystatechange = function() 
    {
        if (this.readyState == 4 && this.status == 200) 
        {
            console.log(this.responseText);
        }
    };

    xhr.send(JSON.stringify({
        id : _id,
        valname : _valname,
        val : _val,
        max : _max
    }));
    
    return _val;
}

function FocusChanged (_val, _valname)
{
    if (_val == '') 
    {
        _val = '0';
        if (_valname.substring(1, 3) == "char") 
        {
            _val = '1';
        }
    }

    return _val;
}