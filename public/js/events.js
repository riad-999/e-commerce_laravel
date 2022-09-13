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
const productsContainer = document.querySelector('.products-container');
const prices = document.querySelectorAll('.price');
const checksContainers = document.querySelectorAll('.checks-container'); 
const openSideFilters = document.getElementById('open-side-filters');
const closeSideFilters = document.getElementById('close-side-filters');
const colorsContainer = document.getElementById('colors-container');
const toggleDropDowns = document.querySelectorAll('.toggle-drop-down');
const addToCartBtn = document.getElementById('add-to-cart');
const cartFroms = document.querySelectorAll('.cart-form');
const qteInput = document.getElementById('quantity');
const sideCart = document.getElementById('side-cart');
const closeSideCartBtn = document.getElementById('close-side-cart');
const updateQuantityInputs = document.querySelectorAll('.update-quantity');
const openSidebar = document.getElementById('open-sidebar');
const closeSidebar = document.getElementById('close-sidebar');
const openAdminbar = document.getElementById('open-adminbar');
const closeAdminbar = document.getElementById('close-adminbar');
const radios = document.querySelectorAll('input[data-radio="true"]');
const promoCodeProductsSection = document.getElementById('add-promo-code');
const cutSelect = document.getElementById('cut-select');
const shipmentTypeInputs = document.querySelectorAll('input[name="shipment_type"]');
const saveBtn = document.getElementById('save-btn');
const saveBtns = document.querySelectorAll('button[data-save="true"]');
const stars = document.querySelectorAll('div[data-star="true"]');
// const loadingBtns = document.querySelector('button[data-loading="true"]');
let checkFlag = false;
const imageSelectionHandler = (event) => {
    const input = event.currentTarget;
    if(input.classList.contains('main-image')) {
        const oldImage = input.parentElement.nextElementSibling;
        if(oldImage && oldImage.classList.contains('main-Image'))
        {
            oldImage.remove();
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
        const oldContainer = input.parentElement.nextElementSibling;
        const images = Array(len).fill(0).map((_,index) => {
            const image = document.createElement('img');
            image.src = URL.createObjectURL(input.files[index]);
            if(oldContainer.dataset.full)
                image.classList.add('w-full');
            else
                image.width = '100';
            image.classList.add('block');
            return image;
        });
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
    if(input.type == 'number') {
        input.value = '0';
    }
    if(input.type == 'color') {
        input.value = '#010101';
    }
}
const closeAlertHandler = event => {
    const btn = event.currentTarget;
    const alert = btn.closest('.Alert');
    alert.classList.remove('!opacity-100');
    alert.classList.add('invisible');
} 
const openModal = event => {
    const id = event.currentTarget.dataset.id;
    const modal = document.getElementById(id);
    modal.style.opacity = '1';
    modal.classList.remove('invisible');
    if(modal.dataset.form) {
        const childs = modal.firstElementChild.children;
        for(let i = 0; i < childs.length; i++) {
            if(childs[i].tagName == 'FORM') {
                childs[i].action = 
                    event.currentTarget.dataset.route;
                    break;
            }
        }
    }
}
const closeModal = () => {
    const id = event.currentTarget.dataset.id;
    const modal = document.getElementById(id);
    modal.style.opacity = '0';
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
    document.getElementById('duration').textContent = wilaya.duration;
    if(radio.checked){
        document.getElementById('cost').textContent = `${wilaya.desk}Da`;
        const subTotal = parseInt(document.getElementById('sub-total').dataset.amount);
        const shipment = wilaya.desk;
        document.getElementById('top-cost').textContent = `${shipment}Da`;
        document.getElementById('total').textContent = `${subTotal + shipment}Da`;
    }
    else {
        document.getElementById('cost').textContent = `${wilaya.home}Da`;
        const subTotal = parseInt(document.getElementById('sub-total').dataset.amount);
        const shipment = wilaya.home;
        document.getElementById('top-cost').textContent = `${shipment}Da`;
        document.getElementById('total').textContent = `${subTotal + shipment}Da`;
    }
}
const shipmentTypeChangeHanlder = () => {
    const value = document.querySelector('select[name="wilaya"]').value;
    const radio = document.querySelector('input[value="au bureau"]');
    // const radio_ = document.querySelector('input[value="à domicile"]');
    wilaya = Wilayas.find(item => item.name == value);
    document.getElementById('duration').textContent = wilaya.duration;
    if(radio.checked) {
        document.getElementById('cost').textContent = `${wilaya.desk}Da`;
        const subTotal = parseInt(document.getElementById('sub-total').dataset.amount);
        const shipment = wilaya.desk;
        document.getElementById('top-cost').textContent = `${shipment}Da`;
        document.getElementById('total').textContent = `${subTotal + shipment}Da`;
    }
    else {
        document.getElementById('cost').textContent = `${wilaya.home}Da`;
        const subTotal = parseInt(document.getElementById('sub-total').dataset.amount);
        const shipment = wilaya.home;
        document.getElementById('top-cost').textContent = `${shipment}Da`;
        document.getElementById('total').textContent = `${subTotal + shipment}Da`;
    }
}
const colorChangeHandler = (event) => {
    if(event.target.closest('.color-square')) {
        const square = event.target.closest('.color-square');
        const {id,src} = square.dataset;
        const img = document.getElementById(id);
        img.src = src;
        const container = square.closest('.colors-container');
        square.classList.add('outline-secondary');
        square.classList.add('outline-2');
        square.classList.add('outline');
        const list = container.children;
        for (let i = 0; i < list.length; i++) {
            if(list[i] != square) {
                list[i].classList.remove('outline-secondary');
                list[i].classList.remove('outline-2');
                list[i].classList.remove('outline');
            }
        }
        
    }
}
const singleProductColorChangeHandler = (event) => {
    if(!event.target.closest('.color-square')) 
        return;
    const square = event.target.closest('.color-square');
    let {id,images,quantity,color,product} = square.dataset;
    const imagesContainer = document.getElementById(id);
    const imageElements = imagesContainer.children;
    for (let i = 0; i < imageElements.length; i++) {
        imageElements[i].remove();
    }
    images = JSON.parse(images);
    images.forEach(image => {
        const img = document.createElement("img");
        img.src = image;
        img.classList.add('swiper-slide');
        img.classList.add('block');
        img.classList.add('desk:px-12')
        imagesContainer.append(img);
    });
    const container = square.closest('.colors-container');
    square.classList.add('outline-secondary');
    square.classList.add('outline-2');
    square.classList.add('outline');
    const list = container.children;
    for (let i = 0; i < list.length; i++) {
        if(list[i] != square) {
            list[i].classList.remove('outline-secondary');
            list[i].classList.remove('outline-2');
            list[i].classList.remove('outline');
        }
    }
    const leftQauntity = document.querySelectorAll('.left-quantity');
    leftQauntity.forEach(item => item.textContent = `${quantity} disponible`);
    const cart = document.getElementById('add-to-cart');
    cart.dataset.color = color;
    cart.dataset.product = product;
    cart.dataset.image = images[0];
    qteInput.max = quantity;
}
// const priceChangeHandler = (event) => {
//     const id = event.currentTarget.dataset.id;
//     const price = document.getElementById(id);
//     price.textContent = `${event.currentTarget.value}Da`;
// }
const checkHandler = (event) => {
    if(event.target.tagName === "INPUT") 
        return;
    // if(!checkFlag && event.target.tagName === "LABEL")
    //     return;
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
const toggleDropDownHandler = (event) => {
    const {id} = event.currentTarget.dataset;
    const showBtn = document.querySelector(`#${event.currentTarget.id} .show`);
    const colseBtn = document.querySelector(`#${event.currentTarget.id} .close`);
    showBtn.classList.toggle('!hidden');
    colseBtn.classList.toggle('!hidden');
    const dropdown = document.getElementById(id);
    const height = dropdown.clientHeight;
    if(dropdown.parentElement.clientHeight) 
         dropdown.parentElement.style.height = `0px`;
    else
        dropdown.parentElement.style.height = `${height}px`;
}
const addToCartHanlder = event => {
    const img = document.getElementById('cart-image');
    const input = document.getElementById('color_id');
    const {color,image} = event.currentTarget.dataset;
    img.src = image;
    input.value = color;
}
const windowLoadHandler = () => {
    if(sideCart) {
        setInterval(() => {
            sideCart.classList.add('translate-x-0');
        }, 500);
    }
    countdown();
}
const closeSideCart = () => {
    sideCart.classList.add('!translate-x-full');
}
const updateQuantityHandler = async event => {
    if(!event.currentTarget.classList.contains('update-quantity'))
        return;
    const id = event.currentTarget.id;
    const {id:input_id, max, product_id, color_id} = event.currentTarget.dataset;
    const flag = event.target.dataset.flag;
    const input = document.getElementById(input_id);
    const quantity = flag ==='increase' ? parseInt(input.value) + 1 
    : parseInt(input.value) - 1;
    if((quantity > max && flag === 'increase') || 
        (quantity == 0 && flag === 'decrease'))
        return;
    event.currentTarget.classList.add('opacity-50')
    event.currentTarget.classList.add('pointer-events-none');
    let subTotal = null;
    try {
        const res = await axios.patch(`${serverEndPoint}/cart`, {
            product_id, color_id, quantity
        });
        subTotal = res.data.sub_total;
    } catch(error) {
        console.log(error);
        if(error.response && error.response.status > 400 && error.response.status < 500) {
            // auth error
        }
        else if(error.request) {
            // no response received 
        }
        else {
            // redirect to error page
        }
    }

    const currentT = document.getElementById(id);
    currentT.classList.remove('opacity-50')
    currentT.classList.remove('pointer-events-none');
    input.value = quantity;
    document.querySelectorAll(`div[data-id="${input_id}"] .quantity`)
    .forEach(item => item.textContent = quantity);
    document.getElementById('sub-total').textContent = `${subTotal} Da`;
}
const sidebarToggleHandler = () => 
    document.getElementById('sidebar').classList.toggle('!translate-x-full');
const adminbarToggleHandler = () => {
    document.getElementById('adminbar').classList.toggle('translate-x-full');
}
const radiosChangeHandler = event => {
    const {id,active} = event.currentTarget.dataset;
    const element = document.getElementById(id);
    const customSection = document.getElementById('custom-section');
    if(active) {
        element.disabled = false;
        if(customSection) {
            customSection.classList.add('opacity-40');
            customSection.classList.add('pointer-events-none');
        }
    } else {
        element.disabled = true;
        if(customSection) {
            customSection.classList.remove('opacity-40');
            customSection.classList.remove('pointer-events-none');
        }
    }
}
const cutSelectInputHandler = async event => {
    const value = event.currentTarget.value;
    const url = `${serverEndPoint}/set-session`;
    try {
        await axios.post(url, {
            key: 'selected_cut',
            value: value
        });
    } catch(error) {
        console.log(error);
        if(error.response && error.response.status > 400 && error.response.status < 500) {
            // auth error
        }
        else if(error.request) {
            // no response received 
        }
        else {
            // redirect to error page
        }
    }
}
const addPromoCodeToProductHandler = async event => {
    if(
        !event.target.dataset.add &&
        !event.target.closest('button')    
    )
        return;
    const btn = event.target.dataset.add ? event.target : event.target.closest('button');
    btn.classList.add('opacity-50');
    btn.classList.add('pointer-events-none');
    const {code, product} = btn.dataset;
    const cut = document.getElementById('cut-select').value;
    const url = `${serverEndPoint}/promo-codes/${code}/assocations`
    try {
        await axios.post(url, {
            product,
            cut
        });
    } catch(error) {
        console.log(error);
        if(error.response && error.response.status > 400 && error.response.status < 500) {
            // auth error
        }
        else if(error.request) {
            // no response received 
        }
        else {
            // redirect to error page
        }
    }
    btn.textContent = `${cut}%`;
    btn.classList.remove('opacity-50');
    btn.classList.remove('pointer-events-none');
}
let clearId = null;
const saveHandler = async event => {
    const btn = event.currentTarget;
    const {state, product} = btn.dataset;
    btn.classList.add('opacity-40');
    btn.classList.add('pointer-events-none');
    if(!product)
        return;
    const url = `${serverEndPoint}/saves`;
    let content = '';
    try {
        if(state === 'saved') {
            await axios.post(url, {
                state,
                product_id: product
            });

            document.querySelector(`#${btn.id} i[data-icone="saved-icone"]`).classList.add('!hidden');
            document.querySelector(`#${btn.id} i[data-icone="unsaved-icone"]`).classList.remove('!hidden');
            content = 'enlevé';
        }
        else {
            await axios.post(url, {
                state,
                product_id: product
            });
            document.querySelector(`#${btn.id} i[data-icone="saved-icone"]`).classList.remove('!hidden');
            document.querySelector(`#${btn.id} i[data-icone="unsaved-icone"]`).classList.add('!hidden');
            content = 'eregistré';
        }
    } catch(error) {
        console.log(error);
        if(error.response && error.response.status > 400 && error.response.status < 500) {
            // auth error
        }
        else if(error.request) {
            // no response received 
        }
        else {
            // redirect to error page
        }
    }
    btn.dataset.state = state === 'saved' ? 'unsaved' : 'saved';
    btn.classList.remove('opacity-40');
    btn.classList.remove('pointer-events-none');
    const notice = document.querySelector(`#${btn.id} .save-notice`);
    notice.classList.add('scale-100');
    notice.textContent = content;
    clearTimeout(clearId);
    clearId = setTimeout(() => {
        notice.classList.remove('scale-100');
    }, 1000);
}
const reviewChangeHandler = event => {
    const input = document.getElementById('review');
    const rate = parseInt(event.currentTarget.dataset.rate);
    input.value = rate;
    stars.forEach(star => {
        if(parseInt(star.dataset.rate) > rate) {
            document.querySelector(`#${star.id} i[data-type="solid"]`).classList.add('!hidden');
            document.querySelector(`#${star.id} i[data-type="empty"]`).classList.remove('!hidden');
        } else {
            document.querySelector(`#${star.id} i[data-type="solid"]`).classList.remove('!hidden');
            document.querySelector(`#${star.id} i[data-type="empty"]`).classList.add('!hidden');
        }
    });
    document.getElementById('review-value').textContent = `(${rate})`;
}
// const loadingBtnHandler = () => {
//     document.getElementById('loading').classList.remove('invisible');
// }
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

const countdown = () => {
    if(!document.getElementById('countdown'))
        return;
    const second = 1000;
    const minute = second * 60;
    const hour = minute * 60;
    const day = hour * 24;
    // const countDown = new Date('09/02/2022').getTime();
    let x = setInterval(() => {
        const now = new Date().getTime();
        const distance = countDown - now;

        document.getElementById("days").innerText = Math.floor(distance / (day)),
        document.getElementById("hours").innerText = Math.floor((distance % (day)) / (hour)),
        document.getElementById("minutes").innerText = Math.floor((distance % (hour)) / (minute)),
        document.getElementById("seconds").innerText = Math.floor((distance % (minute)) / second);

        //do something later when date is reached
        if (distance < 0) {
            document.getElementById('countdown').remove();
            document.getElementById('promo').remove();
            document.getElementById('price').classList.remove('line-through');
            clearInterval(x);
        }
        //seconds
    },1000);
}

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
if(productsContainer) {
    productsContainer.addEventListener('click',colorChangeHandler);
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
if(colorsContainer) {
    colorsContainer.addEventListener('click',singleProductColorChangeHandler);
}
if(toggleDropDowns.length) {
    toggleDropDowns.forEach(item => item.addEventListener('click',toggleDropDownHandler));
}
if(addToCartBtn) {
    addToCartBtn.addEventListener('click',addToCartHanlder);
}
if(closeSideCartBtn) {
    closeSideCartBtn.addEventListener('click',closeSideCart);
}
if(updateQuantityInputs.length) {
    updateQuantityInputs.forEach(item => item.addEventListener('click',updateQuantityHandler));
}
if(openSidebar && closeSidebar) {
    openSidebar.addEventListener('click',sidebarToggleHandler);
    closeSidebar.addEventListener('click',sidebarToggleHandler);
}
if(openAdminbar && closeAdminbar) {
    openAdminbar.addEventListener('click',adminbarToggleHandler);
    closeAdminbar.addEventListener('click',adminbarToggleHandler);
}
if(radios.length) {
    radios.forEach(item => item.addEventListener('change', radiosChangeHandler));
}
if(promoCodeProductsSection) {
    promoCodeProductsSection.addEventListener('click',addPromoCodeToProductHandler);
}
if(cutSelect) {
    cutSelect.addEventListener('input',cutSelectInputHandler);
}
if(shipmentTypeInputs.length) {
    shipmentTypeInputs.forEach(item => item.addEventListener('change',shipmentTypeChangeHanlder));
}
if(saveBtn) {
    saveBtn.addEventListener('click',saveHandler);
}
if(saveBtns.length) {
    saveBtns.forEach(btn => btn.addEventListener('click', saveHandler));
}
if(stars.length) {
    stars.forEach(star => star.addEventListener('click', reviewChangeHandler));
}
// if(loadingBtns.length) {
//     loadingBtns.forEach(btn => btn.addEventListener('click', loadingBtnHandler));
// }
// console.log(loadingBtns);
// if(cartFroms.length) {
//     cartFroms.forEach(item => item.addEventListener('submit',cartFormSubmitHandler)); 
// }
// if(qteInput) {
//     qteInput.addEventListener('input',quantityChangeHandler);
// }
window.addEventListener('DOMContentLoaded',windowLoadHandler);