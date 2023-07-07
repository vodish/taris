
export let root = 'vodish';

export let list = {
    'vodish' : {
        id: 'vodish',
        name: 'vodish',
        type: 'User',
        dir: [],
        rows: ['vodish-taris', '13', '14', '12', '232', '231'],
    },
    'vodish-taris' : {
        id: 'vodish-tatis',
        name: 'vodish-tatis',
        type: 'File',
        dir: ['vodish', 'vodish'],
        rows: [],
        links: [],
    },
    'p1' : {
        id: 'p1',
        name: 'p1',
        content: ``,
    },
    '13': {
        id: '13',
        dir: ['root'],
        type: 'Row',
        content: `<div>Это сразу первая страница. Создать</div>
                <ul>
                    <li>Проект</li>
                    <li>Файл</li>
                    <li>Обещание в нутри файла</li>
                </ul>`,
    },
    '14': {
        id: '14',
        dir: ['root'],
        type: 'Row',
        content: `<p>Еще одна позиция</p>
                <p>Еще одна позиция</p>`,
    },
    '12': {
        id: '12',
        dir: ['root'],
        rows: ['42'],
        type: 'File',
        name: 'file.name',
        comment: `какой-то комментарий к файлу`,
    },
    '232': {
        id: '232',
        dir: ['root'],
        type: 'Row',
        content: `Являясь всего лишь частью общей картины, тщательные исследования конкурентов объединены в целые кластеры себе подобных. Повседневная практика показывает, что постоянный количественный рост и сфера нашей активности предполагает независимые способы реализации форм воздействия. `
    },
    '231':{
        id: '231',
        dir: ['root'],
        type: 'Row',
        content: `Lorem ipsum dolor sit amet consectetur adipisicing elit. Suscipit nemo beatae ratione maiores quo. Odio labore ducimus ipsa adipisci maxime eligendi minus libero cumque veniam maiores. Atque nulla quidem perspiciatis. `
    },
    '42': {
        id: '42',
        dir: ['root', '12'],
        type: 'Row',
        content: `Являясь всего лишь частью общей картины, тщательные исследования конкурентов объединены в целые кластеры себее подобных. Повседневная практика показывает, что постоянный количественный рост и сфера нашей активности предполагает независимые способы реализации форм воздействия. `
    },
}
