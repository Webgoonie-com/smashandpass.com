import {
  swal,
  removeSwal,
  $$,
  CLASS_NAMES,
} from './utils';

const { 
  CONTENT,
} = CLASS_NAMES;

afterEach(() => removeSwal());

describe("show content", () => {

  test("shows no content by default", () => {
    swal("Hello");

    expect($$(CONTENT).length).toBe(0);
  });

  test("shows input when using content: 'input'", () => {
    swal({
      content: "input",
    });

    const inputSelector = `${CONTENT}__input`;

    expect($$(CONTENT).length).toBe(1);
    expect($$(inputSelector).length).toBe(1);
    expect($$(inputSelector).get(0).getAttribute('type')).toBeNull();
  });

  test("can customize input with more advanced content options", () => {
    swal({
      content: {
        element: "input",
        attributes: {
          placeholder: "Type your password",
          type: "password",
        },
      },
    });

    const inputSelector = `${CONTENT}__input`;

    expect($$(CONTENT).length).toBe(1);
    expect($$(inputSelector).length).toBe(1);
    expect($$(inputSelector).get(0).getAttribute('type')).toBe('password');
    expect($$(inputSelector).get(0).getAttribute('placeholder')).toBe('Type your password');
  });

  test("can set content to custom DOM node", () => {
    let btn = document.createElement('button');
    btn.classList.add('custom-element');

    swal({
      content: btn,
    });

    expect($$(CONTENT).length).toBe(1);
    expect($$('custom-element').length).toBe(1);
  });

});

