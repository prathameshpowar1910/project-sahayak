import base64
from pathlib import Path

import streamlit as st
from PyPDF2 import PdfReader
from langchain.text_splitter import CharacterTextSplitter
from langchain.embeddings import HuggingFaceInstructEmbeddings,OpenAIEmbeddings
from langchain.vectorstores import FAISS
from langchain.memory import ConversationBufferMemory
from langchain.chains import ConversationalRetrievalChain
from htmlTemplates import css, bot_template, user_template
from langchain.chat_models import ChatOpenAI
from langchain.llms import HuggingFaceHub
from dotenv import load_dotenv
import os

def get_txt_text(txt_files):
    raw_text = ''
    for txt_file in txt_files:
        raw_text += txt_file.getvalue().decode('utf-8') + '\n'
    return raw_text


def get_pdf_text(pdf_docs):
    text = ""
    for pdf in pdf_docs:
        pdf_reader = PdfReader(pdf)
        for page in pdf_reader.pages:
            text += page.extract_text()
    return text


def get_text_chunks(text):
    text_splitter = CharacterTextSplitter(
        separator="\n",
        chunk_size=1000,
        chunk_overlap=200,
        length_function=len
    )
    chunks = text_splitter.split_text(text)
    return chunks


def get_vectorstore(text_chunks):
    # embeddings = HuggingFaceInstructEmbeddings(model_name="hkunlp/instructor-xl")
    embeddings = OpenAIEmbeddings()
    vectorstore = FAISS.from_texts(texts=text_chunks, embedding=embeddings)
    return vectorstore


def get_conversation_chain(vectorstore):
    # llm = HuggingFaceHub(repo_id="google/flan-t5-xxl", model_kwargs={"temperature": 0.5, "max_length": 512})
    llm = ChatOpenAI()
    memory = ConversationBufferMemory(
        memory_key='chat_history', return_messages=True)
    conversation_chain = ConversationalRetrievalChain.from_llm(
        llm=llm,
        retriever=vectorstore.as_retriever(),
        memory=memory
    )
    return conversation_chain


def handle_userinput(user_question):
    response = st.session_state.conversation({'question': user_question})
    st.session_state.chat_history = response['chat_history']

    for i, message in enumerate(st.session_state.chat_history):
        if i % 2 == 0:
            st.write(user_template.replace(
                "{{MSG}}", message.content), unsafe_allow_html=True)
        else:
            st.write(bot_template.replace(
                "{{MSG}}", message.content), unsafe_allow_html=True)

def img_to_bytes(img_path):
    img_bytes = Path(img_path).read_bytes()
    encoded = base64.b64encode(img_bytes).decode()
    return encoded

# header_html = "<img src='data:image/png;base64,{}' style='height:40px' class='img-fluid'>".format(
#     img_to_bytes("logo.png")
# )


def main():
    load_dotenv()
    st.set_page_config(page_title="Sahayak-Connect", page_icon=":books:")
    st.write(css, unsafe_allow_html=True)

    if "conversation" not in st.session_state:
        st.session_state.conversation = None
    if "chat_history" not in st.session_state:
        st.session_state.chat_history = None

    # st.header("Sahayak-Connect")
    # st.markdown(
    #     header_html, unsafe_allow_html=True
    # )
    # icon_path = "logo.png"

    # Display the custom header using HTML and CSS
    st.markdown(
        f"""
        <div style="display: flex; align-items: center;">
            <div style="flex: 1;">
                <h1 style="margin: 0;">Sahayak-Connect</h1>
            </div>
            <div style="flex: 0;">
                <img src='data:image/png;base64,{img_to_bytes("logo.png")}' width="50" class='img-fluid' alt="Logo">
            </div>
        </div>
        """,
        unsafe_allow_html=True
    )
    user_question = st.text_input("Ask a question about your documents:")
    if user_question:
        handle_userinput(user_question)

    with st.sidebar:
        st.subheader("Your documents")
        txt_docs = st.file_uploader(
            "Upload your TXTs here and click on 'Extract'", accept_multiple_files=True, type=['txt'])
        if st.button("Extract"):
            with st.spinner("Extracting"):
                # get txt text
                raw_text = get_txt_text(txt_docs)

                # get the text chunks
                text_chunks = get_text_chunks(raw_text)

                # create vector store
                vectorstore = get_vectorstore(text_chunks)

                # create conversation chain
                st.session_state.conversation = get_conversation_chain(
                    vectorstore)


if __name__ == '__main__':
    main()
