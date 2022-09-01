<div class="questions lazy entered loaded"
     data-bg="/images/common/questions-bg.jpg" data-ll-status="loaded"
     style="background-image: url(&quot;/images/common/questions-bg.jpg&quot;);">
    <div class="questions__heading">
        <div class="questions__title centered">Есть вопросы?
            <br>Нужна конcультация по вопросам покупки?</div>
        <div class="questions__grid">
            <div class="questions__item item-questions">
                <div class="item-questions__icon">
                    <svg width="23" height="23" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M.56 3.007A2.427 2.427 0 0 1 2.987.58h3.979c.522 0 .985.334 1.15.83l1.818 5.452a1.213 1.213 0 0 1-.608 1.469L6.585 9.7a13.398 13.398 0 0 0 6.694 6.693l1.37-2.739c.27-.54.896-.799 1.468-.608l5.452 1.817c.496.166.83.63.83 1.152v3.978a2.427 2.427 0 0 1-2.427 2.427H18.76C8.708 22.42.56 14.271.56 4.22V3.007Z" fill="#fff" stroke="#fff" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </div>
                <div class="item-questions__data">
                    <div class="item-questions__label">Звоните по телефону</div>
                    <a class="item-questions__link" href="tel:{{ preg_replace('/[^\d]+/', '', Settings::get('questions_phone')) }}">{{ Settings::get('questions_phone') }}</a>
                </div>
            </div>
            <div class="questions__item item-questions">
                <div class="item-questions__icon">
                    <svg width="28" height="22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1.326 3.967a2.825 2.825 0 0 1 2.816-2.834h19.715a2.825 2.825 0 0 1 2.816 2.834v14.169a2.825 2.825 0 0 1-2.816 2.833H4.142a2.825 2.825 0 0 1-2.816-2.833V3.966Z" fill="#fff"></path>
                        <path d="M1.883 4.553A1 1 0 1 0 .77 6.213l1.114-1.66Zm10.554 8.284-.557.83.557-.83Zm3.125 0-.557-.83.557.83ZM27.23 6.214a1 1 0 0 0-1.114-1.661l1.114 1.66ZM4.143 2.133h19.714v-2H4.142v2Zm21.53 1.834v14.169h2V3.966h-2Zm-1.816 16.002H4.142v2h19.715v-2Zm-21.53-1.833V3.966h-2v14.17h2Zm1.816 1.833a1.825 1.825 0 0 1-1.817-1.833h-2c0 2.111 1.703 3.833 3.817 3.833v-2Zm21.53-1.833a1.825 1.825 0 0 1-1.816 1.833v2c2.113 0 3.816-1.722 3.816-3.833h-2ZM23.857 2.133c.997 0 1.816.815 1.816 1.834h2c0-2.112-1.703-3.834-3.816-3.834v2Zm-19.715-2C2.03.133.326 1.855.326 3.967h2c0-1.02.82-1.834 1.817-1.834v-2ZM.77 6.213l11.111 7.454 1.114-1.66-11.11-7.454-1.115 1.66Zm15.35 7.454L27.23 6.214l-1.114-1.661-11.111 7.454 1.114 1.66Zm-4.239 0c1.283.861 2.956.861 4.239 0l-1.114-1.66a1.802 1.802 0 0 1-2.01 0l-1.115 1.66Z" fill="#E08735"></path>
                    </svg>
                </div>
                <div class="item-questions__data">
                    <div class="item-questions__label">Задавайте вопросы по электронной почте</div>
                    <a class="item-questions__link" href="mailto:{{ Settings::get('questions_email') }}">Email: {{ Settings::get('questions_email') }}</a>
                </div>
            </div>
        </div>
        <div class="questions__label">Доставка в любой регион России, страны СНГ, ЭКСПОРТ</div>
    </div>
</div>
