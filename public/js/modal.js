export default class Modal {
  open(content) {
    this.modal = document.createElement('dialog');
    var text = document.createElement('p');
    var close = document.createElement('button');

    text.innerHTML = content;
    close.innerHTML = 'Close';

    this.modal.appendChild(text);
    this.modal.appendChild(close);
    document.body.appendChild(this.modal);

    document.body.classList.add('overflow-hidden');
    this.modal.showModal();
    close.addEventListener('click', () => this.close());
  }

  open_input(content, placeholder, callback) {
    this.modal = document.createElement('dialog');
    var wrapper = document.createElement('div');
    var header = document.createElement('h2');
    var input = document.createElement('input');
    var btnWrapper = document.createElement('div');
    var submit = document.createElement('button');
    var close = document.createElement('button');

    header.innerHTML = 'Send invitation';
    input.type = 'text';
    input.placeholder = placeholder;
    submit.innerHTML = 'Send';
    close.innerHTML = 'Close';

    this.modal.appendChild(wrapper);
    wrapper.appendChild(header);
    wrapper.appendChild(input);
    wrapper.appendChild(btnWrapper);
    btnWrapper.appendChild(submit);
    btnWrapper.appendChild(close);

    this.modal.style.border = '2px solid var(--black)';
    this.modal.style.borderRadius = '16px';
    this.modal.style.minWidth = '50%';
    wrapper.classList.add('col', 'gap-1r');
    submit.classList.add('bubble', 'red', 'clickable', 'bold');
    close.classList.add('bubble', 'black', 'clickable', 'bold');
    btnWrapper.classList.add('row', 'gap-05r');

    document.body.appendChild(this.modal);
    document.body.classList.add('overflow-hidden');

    this.modal.showModal();

    submit.addEventListener('click', () => {
      if(input.value === '') {
        alert('Please enter a value');
        return;
      }
      callback(input.value);
      this.close();
    });
    close.addEventListener('click', () => this.close());
  }

  close() {
    this.modal.close();
    document.body.classList.remove('overflow-hidden');
  }
}
