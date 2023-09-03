let step=1;const initialStep=1,finalStep=3,appointment={usuarioId:"",name:"",date:"",time:"",selectedServices:[]};function runApp(){showSection(),tab(),pagination(),previousStep(),nextStep(),changeSelectedTab(),showServices(),getId(),getName(),getDate(),getTime()}function tab(){document.querySelectorAll(".tab").forEach(e=>{e.addEventListener("click",(function(e){step!==parseInt(e.target.dataset.step)&&(step=parseInt(e.target.dataset.step),showSection(),pagination())}))})}function changeSelectedTab(){document.querySelector(".active").classList.remove("active");document.querySelector(`[data-step="${step}"]`).classList.add("active")}function showSection(){document.querySelector(".show").classList.remove("show");document.querySelector("#step-"+step).classList.add("show"),changeSelectedTab()}function pagination(){const e=document.querySelector("#previous"),t=document.querySelector("#next");1===step?(e.classList.add("btn-hide"),t.classList.remove("btn-hide")):step>1&&step<3?(e.classList.remove("btn-hide"),t.classList.remove("btn-hide")):3===step&&(e.classList.remove("btn-hide"),t.classList.add("btn-hide"),showSummary()),showSection()}function previousStep(){document.querySelector("#previous").addEventListener("click",(function(){step>1&&(step--,pagination())}))}function nextStep(){document.querySelector("#next").addEventListener("click",(function(){step<3&&(step++,pagination())}))}async function fetchServices(){try{const e="/api/services",t=await fetch(e);return await t.json()}catch(e){console.log(e)}}async function showServices(){const e=await fetchServices(),t=document.querySelector(".all-services");e.forEach(e=>{const{id:n,nombre:a,precio:c}=e,o=document.createElement("div");o.classList.add("service"),o.dataset.id=n,o.addEventListener("click",()=>{selectService(e)}),o.innerHTML=`\n            <p class="service-name no-margin center-text">${a}</p>\n            <p class="service-price no-margin center-text">$${c}</p>\n        `,t.appendChild(o)})}function selectService(e){const{id:t}=e,{selectedServices:n}=appointment;n.some(e=>e.id===t)?appointment.selectedServices=n.filter(e=>e.id!==t):appointment.selectedServices=[...n,e],document.querySelector(`[data-id="${e.id}"]`).classList.toggle("selected")}function getId(){appointment.usuarioId=document.querySelector("#id").value}function getName(){appointment.name=document.querySelector("#name").value}function getDate(){const e=document.querySelector("#date");e.addEventListener("input",(function(t){const n=t.target.value,a=new Date(n).getDay();validateDate(e,n,a)}))}function getTime(){const e=document.querySelector("#time");e.addEventListener("input",(function(t){const n=t.target.value,a=n.split(":")[0],c=n.split(":")[1];validateHour(e,n,a,c)}))}function createInputError(e){const t=document.createElement("span");return t.classList.add("input-error"),t.textContent=""+e,t}function createAlert(e,t){const n=document.createElement("span");return n.classList.add("alert"),n.classList.add(e),n.textContent=t,n}function validateDate(e,t,n){if([5,6].includes(n)){if(null!==document.querySelector(".date-input .input-error"))return;e.value="";const t=createInputError("No se puede agendar en fines de semana");document.querySelector(".date-input").appendChild(t),setTimeout(()=>{t.remove()},3e3)}else appointment.date=t}function validateHour(e,t,n){const a=document.querySelector(".time-input");if(n<9||n>17){if(e.value="",null!==document.querySelector(".time-input .input-error"))return;error=createInputError("Ingrese un horario válido (9:00 AM - 5:00 PM)"),a.appendChild(error),setTimeout(()=>{error.remove()},3e3)}else appointment.time=t}function showSummary(){const e=document.querySelector("#step-3");if(e.textContent="",Object.values(appointment).includes("")||0===appointment.selectedServices.length){if(document.querySelector(".alert.error"))return;const t=createAlert("error","Debes completar todos los campos y seleccionar algún servicio para continuar");return void e.appendChild(t)}{const e=document.querySelector(".alert.error");e&&e.remove()}const t=document.createElement("div");t.classList.add("services-summary");const n=document.createElement("h2");n.textContent="Resumen de servicios",t.appendChild(n);const{name:a,date:c,time:o,selectedServices:r}=appointment;let i=0;r.forEach(e=>{const{nombre:n,precio:a}=e,c=document.createElement("div");c.classList.add("service-summary"),c.innerHTML=`\n            <p><span>Nombre:</span> ${n}</p>\n            <p><span>Precio:</span> $${a}</p>\n        `,t.appendChild(c),i+=parseInt(a)});const s=document.createElement("p");s.classList.add("total-services"),s.innerHTML=`Total: <span>$${i}</span>`,t.appendChild(s);const d=document.createElement("div");d.classList.add("appointment-summary");const p=document.createElement("h2");p.textContent="Resumen de cita";const l=document.createElement("p");l.innerHTML="<span>Nombre: </span> "+a;const u=new Date(c+" 00:00").toLocaleDateString("es-MX",{weekday:"long",year:"numeric",month:"long",day:"numeric"}),m=document.createElement("p");m.innerHTML="<span>Fecha: </span> "+u;const v=document.createElement("p");v.innerHTML="<span>Hora: </span> "+o;const S=document.createElement("button");S.textContent="Crear cita",S.classList.add("send-btn"),S.addEventListener("click",createAppointment),d.appendChild(p),d.appendChild(l),d.appendChild(m),d.appendChild(v),d.appendChild(S),e.appendChild(t),e.appendChild(d)}function createSwalAlert(e,t,n){Swal.fire({icon:e,title:t,text:n}).then(()=>{window.location.reload()})}async function createAppointment(){const{selectedServices:e}=appointment,t=e.map(e=>e.id),n=new FormData;Object.keys(appointment).forEach(e=>{"selectedServices"===e?n.append(e,t):n.append(e,appointment[e])});try{const e=await fetch("/api/appointments",{method:"POST",body:n}),t=await e.json();console.log(t),t&&createSwalAlert("success","Cita creada","Su cita fue creada exitosamente")}catch(e){console.log(e),createSwalAlert("error","Error","Ha ocurrido un error al tratar de crear su cita")}}document.addEventListener("DOMContentLoaded",(function(){runApp()}));