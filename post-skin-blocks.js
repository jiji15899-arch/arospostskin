/**
 * Gutenberg 블록 등록
 * 글쓰기 스킨용 커스텀 블록들
 */

(function(blocks, element, editor) {
    const el = element.createElement;
    const { RichText, InspectorControls, URLInput } = editor;
    const { PanelBody, TextControl } = wp.components;
    const { Fragment } = element;

    // 1. 회색 카드 블록
    blocks.registerBlockType('post-skin/gray-card', {
        title: '회색 카드',
        icon: 'admin-page',
        category: 'common',
        attributes: {
            content: {
                type: 'string',
                source: 'html',
                selector: 'div'
            }
        },
        edit: function(props) {
            const { attributes, setAttributes } = props;
            
            return el(
                'div',
                { className: 'aros-gray-card', style: { background: 'rgb(248, 249, 250)', borderRadius: '16px', padding: '20px', margin: '15px 0' } },
                el(RichText, {
                    tagName: 'div',
                    value: attributes.content,
                    onChange: (content) => setAttributes({ content }),
                    placeholder: '내용을 입력하세요...'
                })
            );
        },
        save: function(props) {
            return el(
                'div',
                { className: 'aros-gray-card' },
                el(RichText.Content, {
                    tagName: 'div',
                    value: props.attributes.content
                })
            );
        }
    });

    // 2. 회색 카드 (중앙 정렬) 블록
    blocks.registerBlockType('post-skin/gray-card-center', {
        title: '회색 카드 (중앙)',
        icon: 'admin-page',
        category: 'common',
        attributes: {
            content: {
                type: 'string',
                source: 'html',
                selector: 'div'
            }
        },
        edit: function(props) {
            const { attributes, setAttributes } = props;
            
            return el(
                'div',
                { className: 'aros-gray-card-center', style: { background: 'rgb(248, 249, 250)', borderRadius: '16px', padding: '25px', textAlign: 'center', margin: '20px 0' } },
                el(RichText, {
                    tagName: 'div',
                    value: attributes.content,
                    onChange: (content) => setAttributes({ content }),
                    placeholder: '내용을 입력하세요...'
                })
            );
        },
        save: function(props) {
            return el(
                'div',
                { className: 'aros-gray-card-center' },
                el(RichText.Content, {
                    tagName: 'div',
                    value: props.attributes.content
                })
            );
        }
    });

    // 3. 파란색 카드 블록
    blocks.registerBlockType('post-skin/blue-card', {
        title: '파란색 카드',
        icon: 'admin-page',
        category: 'common',
        attributes: {
            title: {
                type: 'string',
                default: ''
            },
            content: {
                type: 'string',
                source: 'html',
                selector: 'div'
            }
        },
        edit: function(props) {
            const { attributes, setAttributes } = props;
            
            return el(Fragment, {},
                el(InspectorControls, {},
                    el(PanelBody, { title: '카드 설정' },
                        el(TextControl, {
                            label: '제목',
                            value: attributes.title,
                            onChange: (title) => setAttributes({ title })
                        })
                    )
                ),
                el(
                    'div',
                    { className: 'aros-blue-card', style: { background: '#EEF6FF', borderRadius: '16px', padding: '20px', margin: '15px 0' } },
                    attributes.title && el('h2', { style: { fontSize: '20px', fontWeight: 'bold', color: '#2196F3', marginBottom: '15px' } }, attributes.title),
                    el(RichText, {
                        tagName: 'div',
                        value: attributes.content,
                        onChange: (content) => setAttributes({ content }),
                        placeholder: '내용을 입력하세요...'
                    })
                )
            );
        },
        save: function(props) {
            const { attributes } = props;
            return el(
                'div',
                { className: 'aros-blue-card' },
                attributes.title && el('h2', {}, attributes.title),
                el(RichText.Content, {
                    tagName: 'div',
                    value: attributes.content
                })
            );
        }
    });

    // 4. 흰색 카드 블록
    blocks.registerBlockType('post-skin/white-card', {
        title: '흰색 카드',
        icon: 'admin-page',
        category: 'common',
        attributes: {
            title: {
                type: 'string',
                default: ''
            },
            content: {
                type: 'string',
                source: 'html',
                selector: 'div'
            }
        },
        edit: function(props) {
            const { attributes, setAttributes } = props;
            
            return el(Fragment, {},
                el(InspectorControls, {},
                    el(PanelBody, { title: '카드 설정' },
                        el(TextControl, {
                            label: '제목',
                            value: attributes.title,
                            onChange: (title) => setAttributes({ title })
                        })
                    )
                ),
                el(
                    'div',
                    { className: 'aros-white-card', style: { background: 'white', borderRadius: '16px', padding: '20px', margin: '15px 0', border: '1px solid rgba(0,0,0,0.1)' } },
                    attributes.title && el('h2', { style: { fontSize: '20px', fontWeight: 'bold', color: '#6528f7', marginBottom: '15px' } }, attributes.title),
                    el(RichText, {
                        tagName: 'div',
                        value: attributes.content,
                        onChange: (content) => setAttributes({ content }),
                        placeholder: '내용을 입력하세요...'
                    })
                )
            );
        },
        save: function(props) {
            const { attributes } = props;
            return el(
                'div',
                { className: 'aros-white-card' },
                attributes.title && el('h2', {}, attributes.title),
                el(RichText.Content, {
                    tagName: 'div',
                    value: attributes.content
                })
            );
        }
    });

    // 5. 버튼 블록
    blocks.registerBlockType('post-skin/button', {
        title: '버튼',
        icon: 'button',
        category: 'common',
        attributes: {
            text: {
                type: 'string',
                default: '클릭하기'
            },
            url: {
                type: 'string',
                default: ''
            }
        },
        edit: function(props) {
            const { attributes, setAttributes } = props;
            
            return el(Fragment, {},
                el(InspectorControls, {},
                    el(PanelBody, { title: '버튼 설정' },
                        el(TextControl, {
                            label: '버튼 텍스트',
                            value: attributes.text,
                            onChange: (text) => setAttributes({ text })
                        }),
                        el(TextControl, {
                            label: 'URL',
                            value: attributes.url,
                            onChange: (url) => setAttributes({ url })
                        })
                    )
                ),
                el('div', { className: 'apply-container' },
                    el('div', { className: 'link-container' },
                        el('div', { className: 'button-container', style: { background: 'rgb(101, 40, 247)', borderRadius: '12px', color: 'white', padding: '18px' } },
                            el('div', { className: 'button-content', style: { display: 'flex', justifyContent: 'space-between', alignItems: 'center' } },
                                el('span', { className: 'button-text' }, attributes.text),
                                el('span', {}, '→')
                            )
                        )
                    )
                )
            );
        },
        save: function(props) {
            const { attributes } = props;
            return el('div', { className: 'apply-container' },
                el('div', { className: 'link-container' },
                    el('a', { className: 'custom-link', href: attributes.url },
                        el('div', { className: 'button-container' },
                            el('div', { className: 'button-content' },
                                el('span', { className: 'button-text' }, attributes.text),
                                el('span', {}, '→')
                            )
                        )
                    )
                )
            );
        }
    });

    // 6. 혜택 카드 블록
    blocks.registerBlockType('post-skin/benefit-card', {
        title: '혜택 카드',
        icon: 'star-filled',
        category: 'common',
        attributes: {
            title: {
                type: 'string',
                default: '함께 보면 좋은 글'
            },
            items: {
                type: 'array',
                default: []
            }
        },
        edit: function(props) {
            const { attributes, setAttributes } = props;
            
            const addItem = () => {
                const newItems = [...attributes.items, { text: '새 항목', url: '#', icon: '💰' }];
                setAttributes({ items: newItems });
            };
            
            const updateItem = (index, field, value) => {
                const newItems = [...attributes.items];
                newItems[index][field] = value;
                setAttributes({ items: newItems });
            };
            
            const removeItem = (index) => {
                const newItems = attributes.items.filter((_, i) => i !== index);
                setAttributes({ items: newItems });
            };
            
            return el(Fragment, {},
                el(InspectorControls, {},
                    el(PanelBody, { title: '카드 설정' },
                        el(TextControl, {
                            label: '제목',
                            value: attributes.title,
                            onChange: (title) => setAttributes({ title })
                        }),
                        el('button', {
                            className: 'button button-primary',
                            onClick: addItem,
                            style: { marginTop: '10px' }
                        }, '항목 추가')
                    )
                ),
                el('div', { className: 'aros-gray-card benefit-card', style: { background: 'rgb(248, 249, 251)', borderRadius: '16px', padding: '25px', margin: '20px 0' } },
                    el('h3', { className: 'benefit-title' },
                        el('span', { className: 'icon' }, '🎯 '),
                        attributes.title
                    ),
                    el('div', { className: 'benefit-list', style: { background: 'rgb(243, 244, 246)', borderRadius: '12px', padding: '20px' } },
                        attributes.items.map((item, index) =>
                            el('div', { key: index, style: { marginBottom: '10px', padding: '10px', background: 'white', borderRadius: '8px' } },
                                el(TextControl, {
                                    label: '텍스트',
                                    value: item.text,
                                    onChange: (value) => updateItem(index, 'text', value)
                                }),
                                el(TextControl, {
                                    label: 'URL',
                                    value: item.url,
                                    onChange: (value) => updateItem(index, 'url', value)
                                }),
                                el(TextControl, {
                                    label: '아이콘',
                                    value: item.icon,
                                    onChange: (value) => updateItem(index, 'icon', value)
                                }),
                                el('button', {
                                    className: 'button',
                                    onClick: () => removeItem(index),
                                    style: { marginTop: '5px' }
                                }, '삭제')
                            )
                        )
                    )
                )
            );
        },
        save: function(props) {
            const { attributes } = props;
            return el('div', { className: 'aros-gray-card benefit-card' },
                el('h3', { className: 'benefit-title' },
                    el('span', { className: 'icon' }, '🎯 '),
                    attributes.title
                ),
                el('div', { className: 'benefit-list' },
                    attributes.items.map((item, index) =>
                        el('a', { key: index, href: item.url },
                            el('div', { className: 'benefit-item' },
                                el('span', { className: 'benefit-text' }, '• ' + item.text),
                                el('span', {}, item.icon)
                            )
                        )
                    )
                )
            );
        }
    });

})(
    window.wp.blocks,
    window.wp.element,
    window.wp.blockEditor || window.wp.editor
);
