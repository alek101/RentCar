//
function sredi()
{
    imeInput.value=imeInput.value.trim();
    emailInput.value=emailInput.value.trim();
    telefonInput.value=telefonInput.value.trim();
}

sredi();

imeInput.addEventListener('change',function()
{
    sredi();
});
emailInput.addEventListener('change',function()
{
    sredi();
});
telefonInput.addEventListener('change',function()
{
    sredi();
});