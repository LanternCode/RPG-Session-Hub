var active = 0;
var active_num = 0;

function reveal_panel( panel_number )
{
    if(active == 1 && active_num == panel_number)
    {
        active = 0;
        panel_number = 0;
    }

    let panel1 = (panel_number == 1) ? 'block' : 'none';
    let panel2 = (panel_number == 2) ? 'block' : 'none';
    let panel3 = (panel_number == 3) ? 'block' : 'none';
    let panel4 = (panel_number == 4) ? 'block' : 'none';
    let panel5 = (panel_number == 5) ? 'block' : 'none';

    document.getElementById('editmodulesform').style.display = panel1;
    document.getElementById('addplayersform').style.display = panel2;
    document.getElementById('removeplayers').style.display = panel3;
    document.getElementById('changenames').style.display = panel4;
    document.getElementById('editdices').style.display = panel5;

    if( panel_number != 0 ) active = 1;

    active_num = panel_number;
}

function module_quote_checkbox()
{
    if(document.getElementById('randomquote').checked == 1)
        document.getElementById('randomquoteall').disabled = 0;
    else {
        document.getElementById('randomquoteall').disabled = 1;
        document.getElementById('randomquoteall').checked = 0;
    }
}

function module_dice_checkbox()
{
    if(document.getElementById('goddice').checked == 1)
        document.getElementById('goddiceall').disabled = 0;
    else {
        document.getElementById('goddiceall').disabled = 1;
        document.getElementById('goddiceall').checked = 0;
    }
}
