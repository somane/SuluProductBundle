define(["text!suluproduct/components/bulk-price/bulk-price.html"],function(a){"use strict";var b={minimumQuantity:0,maxBulkElements:4,bulkPriceIdPrefix:"bulk-price-"},c="sulu.products.bulk-price.",d=function(a){return c+(this.options.instanceName?this.options.instanceName+".":"")+a},e=function(){return d.call(this,"initialized")},f=function(a){var c=null,d=null;return this.sandbox.util.foreach(a,function(a,e){parseFloat(a.minimumQuantity)===b.minimumQuantity&&null===d&&(c=a,d=e),a.minimumQuantity=a.minimumQuantity||0===a.minimumQuantity?this.sandbox.numberFormat(parseFloat(a.minimumQuantity),"n"):"",a.price=a.price||0===a.price?this.sandbox.numberFormat(a.price,"n"):""}.bind(this)),null!==d&&a.splice(d,1),c},g=function(a){var c=a.length;if(c<b.maxBulkElements)for(;c<b.maxBulkElements;c++)a.push({});return a},h=function(){this.sandbox.dom.on(this.$el,"change",function(){i.call(this)}.bind(this),"input"),this.sandbox.dom.on(this.$el,"blur",function(){this.sandbox.emit("sulu.content.changed")}.bind(this),"input")},i=function(){var a,c,d,e,f=[],g=this.sandbox.dom.find(".salesprice",this.$el),h=this.sandbox.dom.val(g),i=this.sandbox.dom.data(g,"id"),j=this.sandbox.dom.find(".table tbody tr",this.$el);h&&(a={price:h?this.sandbox.parseFloat(h):null,minimumQuantitiy:b.minimumQuantity,id:i?i:null,currency:this.options.currency},f.push(a)),this.sandbox.util.foreach(j,function(a){e=this.sandbox.dom.data(a,"id"),d=this.sandbox.dom.val(this.sandbox.dom.find("input.minimumQuantity",a)),c=this.sandbox.dom.val(this.sandbox.dom.find("input.price",a)),d&&c&&f.push({minimumQuantity:this.sandbox.parseFloat(d),price:this.sandbox.parseFloat(c),currency:this.options.currency,id:e?e:null})}.bind(this));var k={};k.currency={},k.startDate=$("#js-husky-input-startDate"+this.options.currency.code).val(),k.endDate=$("#js-husky-input-endDate"+this.options.currency.code).val(),k.price=$("#js-input"+this.options.currency.code).val(),k.currency=this.options.currency,this.sandbox.dom.data(this.$el,"itemsSpecialPrice",k),this.sandbox.dom.data(this.$el,"items",f),this.sandbox.emit("sulu.products.bulk-price.changed")},j=function(a){this.sandbox.start([{name:"input@husky",options:{el:"#"+a.startDateHolder,instanceName:a.startDate,inputId:a.startDate,skin:"date"}}]),this.sandbox.start([{name:"input@husky",options:{el:"#"+a.endDateHolder,instanceName:a.endDate,inputId:a.endDate,skin:"date"}}])},k=function(a,b){var c=[];return this.sandbox.util.foreach(a,function(a){a.currency.code===b&&c.push(a)}.bind(this)),c},l=function(a,b){var c={};return this.sandbox.util.foreach(a,function(a){return a.currency.code===b?void(c=a):void 0}.bind(this)),c};return{initialize:function(){var a,b=[],c={},d={};this.groupedPrices={};var m=this.options.currency.code;this.options.data.attributes.prices&&(b=k.call(this,this.options.data.attributes.prices,m),a=f.call(this,b)),this.options.data.attributes.specialPrices&&(c=l.call(this,this.options.data.attributes.specialPrices,m),c.price=this.sandbox.numberFormat(c.price,"n")),d.price="js-input"+m,d.startDate="js-husky-input-startDate"+m,d.endDate="js-husky-input-endDate"+m,d.startDateHolder="js-husky-startDate-holder"+m,d.endDateHolder="js-husky-endDate-holder"+m,c.tmplSelectors=d,b=g.call(this,b),h.call(this),this.render(b,a,c),i.call(this),j.call(this,d),this.sandbox.emit(e.call(this))},render:function(c,d,e){var f={idPrefix:b.bulkPriceIdPrefix,currency:this.options.currency,salesPrice:d,translate:this.sandbox.translate,prices:c,specialPrice:e},g=this.sandbox.util.template(a,f);this.sandbox.dom.append(this.options.el,g)}}});