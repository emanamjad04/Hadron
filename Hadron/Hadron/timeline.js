// let steps = document.querySelector("#steps");
// let wizards = [
//   {
//     complete: true,
//     number: 1,
//     title: "Verify Identity",
//     text:
//       "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugiat pariatur minima nemo? Facilis veniam reprehenderit quaerat aspernatur, quis voluptas voluptate."
//   },
//   {
//     complete: false,
//     number: 2,
//     title: "Create Account",
//     text:
//       "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugiat pariatur minima nemo? Facilis veniam reprehenderit quaerat aspernatur, quis voluptas voluptate."
//   },
//     {
//     complete: false,
//     number: 3,
//     title: "Login",
//     text:
//       "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugiat pariatur minima nemo? Facilis veniam reprehenderit quaerat aspernatur, quis voluptas voluptate."
//   },
// ];

let tickIcon = `<svg viewBox="0 0 512 512" width="100" title="check">
        <path d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z" />`;

// steps.innerHTML = wizards
//   .map(function (wizard) {
//     return (
//       `<div class='step'>` +
//       `<div class='number ${wizard.complete && 'completed'}'>` +
//       (wizard.complete ? tickIcon : wizard.number) +
//       `</div>` +
//       `<div class='info'>` +
//       `<p class='title'>${wizard.title}</p>` +
//       `<p class='text'>${wizard.text}</p>` +
//       "</div>" +
//       "</div>"
//     );
//   })
//   .join("");

// my javascript
let steps2 = document.getElementById("steps");
function makeStep(num, stepname, stepdescription, status){
    let step = document.createElement("div");
    step.className = "step";
    let number = document.createElement("div");
    number.className = "number";
    number.innerHTML = num;
    if(status == "Completed"){
        number.classList.add("completed");
        number.innerHTML = tickIcon;
    }
    let info = document.createElement("div");
    info.className = "info";
    let title = document.createElement("p");
    title.className = "title";
    title.innerHTML = stepname;
    let text = document.createElement("p");
    text.className = "text";
    text.innerHTML = stepdescription;

    info.appendChild(title);
    info.appendChild(text);

    step.appendChild(number);
    step.appendChild(info);

    steps.appendChild(step);
}