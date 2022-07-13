const imagesInputs = document.querySelectorAll('.main-image, .other-images');
const dropdownLables = document.querySelectorAll('.color-label');
const dropdowns = document.querySelectorAll('.dropdown-content');

const imageSelectionHandler = (event) => {
    const input = event.currentTarget;
    if(input.classList.contains('main-image')) {
        const oldImage = input.nextElementSibling;
        if(oldImage && oldImage.classList.contains('main-Image'))
            oldImage.remove();
        const url = URL.createObjectURL(input.files[0]);
        const image = document.createElement('img');
        image.src = url;
        image.width = '260';
        image.classList.add('mb-8');
        image.classList.add('main-Image')
        input.after(image);
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
        const oldContainer = input.nextElementSibling;
        console.log(oldContainer);
        if(oldContainer && oldContainer.classList.contains('container'))
            oldContainer.remove();
        const container = document.createElement('div');
        ['flex', 'gap-4', 'my-8', 'flex-wrap', 'container'].forEach(
            className => container.classList.add(className)
        );
        images.forEach(image => container.append(image));
        input.after(container);
    }
}
const dropdwonToggleHandler = event => {
    const dropdown = event.currentTarget.nextElementSibling;
    dropdown.classList.toggle('!invisible');
};
const colorSelectHandler = event => {
    const btn = event.target.closest('.color-item');
    const label = event.currentTarget.previousElementSibling;
    if(!btn)
        return;
    const id = btn.dataset.id;
    const input = btn.parentElement.parentElement.firstElementChild;
    input.value = id;
    btn.parentElement.classList.toggle('!invisible');
    label.innerHTML = btn.innerHTML;
};

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

if(imagesInputs)
    imagesInputs.forEach(input => 
        input.addEventListener('change',imageSelectionHandler)
    );
if(dropdownLables) {
    dropdownLables.forEach(label => 
        label.addEventListener('click', dropdwonToggleHandler)
    );
}
if(dropdowns) {
    dropdowns.forEach(dropdown => 
        dropdown.addEventListener('click', colorSelectHandler)
    );
}
