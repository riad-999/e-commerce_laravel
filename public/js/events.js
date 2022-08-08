const imagesInputs = document.querySelectorAll('.main-image, .other-images');
const dropdownLables = document.querySelectorAll('.color-label');
const dropdowns = document.querySelectorAll('.dropdown-content');
const edits = document.querySelectorAll('.edit');
const removes = document.querySelectorAll('.remove');
const closeAlert = document.getElementById('alert-close');
const openModalBtns = document.querySelectorAll('.open-modal');
const closeModalBtns = document.querySelectorAll('.close-modal');
const tabs = document.querySelectorAll('.tab');
const wilayaSelect = document.getElementById('wilaya');
const filterDropdowns = document.querySelectorAll('.filter-dropdown');
const productsContainer = document.querySelector('.products-container');
const prices = document.querySelectorAll('.price');
const checksContainers = document.querySelectorAll('.checks-container');
const openSideFilters = document.getElementById('open-side-filters');
const closeSideFilters = document.getElementById('close-side-filters');
let checkFlag = false;

const imageSelectionHandler = (event) => {
    const input = event.currentTarget;
    if(input.classList.contains('main-image')) {
        const oldImage = input.parentElement.nextElementSibling;
        console.log(oldImage);
        if(oldImage && oldImage.classList.contains('main-Image'))
        {
            oldImage.remove();
            console.log('pihs pish');
        }
        const url = URL.createObjectURL(input.files[0]);
        const image = document.createElement('img');
        image.src = url;
        image.width = '260';
        image.classList.add('mb-8');
        image.classList.add('main-Image')
        input.parentElement.after(image);
    }
    else {
        const input = event.currentTarget;
        const len = input.files.length;
        const images = Array(len).fill(0).map((_,index) => {
            const image = document.createElement('img');
            image.src = URL.createObjectURL(input.files[index]);
            image.width = '100';
            image.classList.add('block');
            return image;
        });
        const oldContainer = input.parentElement.nextElementSibling;
        if(oldContainer && oldContainer.classList.contains('container'))
            oldContainer.remove();
        const container = document.createElement('div');
        ['flex', 'gap-4', 'my-8', 'flex-wrap', 'container'].forEach(
            className => container.classList.add(className)
        );
        images.forEach(image => container.append(image));
        input.parentElement.after(container);
    }
}
const dropdwonToggleHandler = event => {
    const dropdown = event.currentTarget.parentElement.lastElementChild;
    dropdown.classList.toggle('!invisible');
};
const colorSelectHandler = event => {
    const btn = event.target.closest('.color-item');
    const label = event.currentTarget.parentElement
    .children[1];
    if(!btn)
        return;
    const id = btn.dataset.id;
    const input = btn.parentElement.parentElement.firstElementChild;
    input.value = id;
    btn.parentElement.classList.toggle('!invisible');
    label.innerHTML = btn.innerHTML;
};
const editHandler = event => {
    const id = event.currentTarget.dataset.id;
    const name = event.currentTarget.dataset.name;
    if(id) {
        const input = document.getElementById(id);
        input.classList.remove('cursor-not-allowed');
        input.classList.remove('opacity-50');
        input.disabled = false;
    }
    if(name) {
        const inputs = document.querySelectorAll(`input[name=${name}]`);
        inputs.forEach(input => {
            input.disabled = false;
            // const div = input.closest('.radio-container');
            // if(div)
            //     div.classList.toggle('opacity-50');
        });
    }
    if(event.currentTarget.dataset.dropdown) {
        const label = event.currentTarget.previousElementSibling;
        label.classList.remove('opacity-50');
        label.classList.remove('!cursor-not-allowed');
        label.classList.remove('pointer-events-none');
    }
}
const removeHandler = event => {
    id = event.currentTarget.dataset.id;
    const input = document.getElementById(id);
    input.classList.remove('cursor-not-allowed');
    input.classList.remove('opacity-50');
    input.disabled = false;
    input.value = '';
    if(input.type == 'color') {
        console.log('pish');
        input.value = '#010101';
    }
}
const closeAlertHandler = event => {
    const btn = event.currentTarget;
    const alert = btn.closest('.Alert');
    alert.classList.remove('opacity-100');
    alert.classList.add('invisible');
} 
const openModal = event => {
    const id = event.currentTarget.dataset.id;
    const modal = document.getElementById(id);
    modal.classList.remove('opacity-0');
    modal.classList.remove('invisible');
    if(modal.dataset.form)
        modal.firstElementChild.action = 
            event.currentTarget.dataset.route;
}
const closeModal = () => {
    const id = event.currentTarget.dataset.id;
    const modal = document.getElementById(id);
    modal.classList.add('opacity-0');
    modal.classList.add('invisible');
}
const tabHanlder = event => {
    const tabParent = event.currentTarget.parentElement;
    Array.prototype.slice.call( tabParent.children ).forEach(
        tab => tab.classList.remove('tab-active')
    );
    event.currentTarget.classList.add('tab-active');
    const id = event.currentTarget.dataset.id;
    const element = document.getElementById(id);
    const children = element.parentElement.children;
    const array = Array.prototype.slice.call( children );
    array.forEach(child => {
        if(child.dataset.tabcontent) {
            if(child.id == id) {
                child.style.height = 'auto';
                child.classList.remove('overflow-hidden');
            }   
            else {
                child.style.height = '0';
                child.classList.add('overflow-hidden');
            } 
        } 
    });
}
const windowLoadHandler = () => {
    const colorInputs = document.querySelectorAll('input[type="color"]');
    colorInputs.forEach(input => input.value = '#010101');
    colorInputs.forEach(input => console.log(input.value))
}
const wilayaSelectHandler = event => {
    const value = event.currentTarget.value;
    const radio = document.querySelector('input[value="au bureau"]');
    const radio_ = document.querySelector('input[value="à domicile"]');
    wilaya = Wilayas.find(item => item.name == value);
    if(!wilaya.desk){
        radio.disabled = true;
        radio_.checked = true;
    } else {
        radio.disabled = false;
    }
}
const toggleFilterDropdownHandler = (event) => {
    const id = event.currentTarget.dataset.id;
    const content = document.getElementById(id);
    const height = content.clientHeight;
    if(!content.parentElement.clientHeight) {
        content.parentElement.style.height = `${height}px`;
    }
    else {
        content.parentElement.style.height = `0px`;
    }
}
const colorChnageHandler = (event) => {
    if(event.currentTarget.classList.contains('color-square') ||
    event.target.closest('.color-square')) {
        const square = event.target.closest('.color-square');
        const {id,src} = square.dataset;
        const img = document.getElementById(id);
        img.src = src;
    }
}
const priceChangeHandler = (event) => {
    const id = event.currentTarget.dataset.id;
    const price = document.getElementById(id);
    price.textContent = `${event.currentTarget.value}Da`;
}
const checkHandler = (event) => {
    checkFlag = !checkFlag;
    if(!checkFlag)
        return;
    const check = event.target.closest('.check');
    if(!check)
        return;
    const {id,value} = check.dataset;
    const input = document.getElementById(id);
    const values = JSON.parse(input.value)
    const index = values.indexOf(value);
    if (index === -1) {
        values.push(value);
    } else {
        values.splice(index, 1);
    }
    input.value = JSON.stringify(values);
}
const openSideFiltersHandler = () => {
    const sidebar = document.getElementById('side-filters');
    sidebar.classList.remove('translate-x-[-100%]');
}
const closeSideFiltersHandler = () => {
    const sidebar = document.getElementById('side-filters');
    sidebar.classList.add('translate-x-[-100%]');
}
// const addColor_image = (event) => {
//     const LIST = ['amd','msi','asus'];
//     color_imageCount++;
//     const container = document.createElement('div');
//     container.className = "pt-4 mt-4 border-t border-solid border-gray-300";

//     let div = document.createElement('div');
//     let label = document.createElement('label');
//     const select = document.createElement('select');
//     label.className = "mb-2 block font-semibold";
//     label.htmlFor = `color${color_imageCount}`;
//     label.innerText = `${color_imageCount}eme coleur`;
//     select.id = `color${color_imageCount}`;
//     select.name = `color${color_imageCount}`;
//     select.className = "select w-full max-w-xs mb-4";
//     LIST.forEach(item => {
//         const option = document.createElement('option');
//         option.value = item;
//         option.innerText = item;
//         select.append(option);
//     });
//     div.append(label);
//     div.append(select);
//     container.append(div);

//     div = document.createElement('div');
//     label = document.createElement('label');
//     let input = document.createElement('input');
//     label.htmlFor = `main-image${color_imageCount}`;
//     label.className = "mb-2 block font-semibold";
//     label.innerText = 'image pricipale';
//     input.type = 'file';
//     input.name = `main-image${color_imageCount}`;
//     input.className = "mb-4 main-image p-1 mb-4 bg-gray-300 border border-gray-500 border-solid round";
//     input.id = `main-image${color_imageCount}`;
//     input.addEventListener('change',imageSelectionHandler);
//     div.append(label);
//     div.append(input);
//     container.append(div);

//     div = document.createElement('div');
//     label = document.createElement('label');
//     input = document.createElement('input');
//     label.htmlFor = `other-images${color_imageCount}`;
//     label.className = "mb-2 block font-semibold";
//     label.innerText = 'autres images';
//     input.type = 'file';
//     input.name = `other-images${color_imageCount}`;
//     input.className = "mb-4 other-images p-1 mb-4 bg-gray-300 border border-gray-500 border-solid round";
//     input.id = `other-image${color_imageCount}`;
//     input.multiple = true;
//     input.addEventListener('change',imageSelectionHandler);
//     div.append(label);
//     div.append(input);
//     container.append(div);

//     const last = event.currentTarget.parentElement;
//     last.before(container);
// }

if(imagesInputs.length)
    imagesInputs.forEach(input => 
        input.addEventListener('change',imageSelectionHandler)
    );
if(dropdownLables.length) {
    dropdownLables.forEach(label => 
        label.addEventListener('click', dropdwonToggleHandler)
    );
}
if(dropdowns.length) {
    dropdowns.forEach(dropdown => 
        dropdown.addEventListener('click', colorSelectHandler)
    );
}
if(edits.length) {
    edits.forEach(edit => edit.addEventListener('click',editHandler));
}
if(removes.length) {
    removes.forEach(remove => remove.addEventListener('click',removeHandler));
}
if(closeAlert) {
    closeAlert.addEventListener('click',closeAlertHandler);
}
if(openModalBtns.length) {
    openModalBtns.forEach(
        btn => btn.addEventListener('click',openModal)
    );
}
if(closeModalBtns.length) {
    closeModalBtns.forEach(
        btn => btn.addEventListener('click',closeModal)
    );
}
if(tabs.length) {
    tabs.forEach(tab => tab.addEventListener('click',tabHanlder));
}
if(wilayaSelect){
    wilayaSelect.addEventListener('change',wilayaSelectHandler);
}
if(filterDropdowns.length) {
    filterDropdowns.forEach(
        item => item.addEventListener('click',toggleFilterDropdownHandler)
    );
}
if(productsContainer) {
    productsContainer.addEventListener('click',colorChnageHandler);
}
if(prices.length) {
    prices.forEach(item => item.addEventListener('input',priceChangeHandler));
}
if(checksContainers.length) {
    checksContainers.forEach(item => item.addEventListener('click',checkHandler));
}
if(openSideFilters) {
    openSideFilters.addEventListener('click',openSideFiltersHandler);
}
if(closeSideFilters) {
    closeSideFilters.addEventListener('click',closeSideFiltersHandler);
}
// window.addEventListener('DOMContentLoaded', windowLoadHandler);


// const input = document.getElementById('date');
// input.addEventListener('change',
//     event => console.log(event.currentTarget.value));