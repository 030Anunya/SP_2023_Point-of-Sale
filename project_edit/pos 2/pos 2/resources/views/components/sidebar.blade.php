      <!-- ============================================================== -->
      <!-- Left Sidebar - style you can find in sidebar.scss  -->
      <!-- ============================================================== -->
      <aside class="left-sidebar" data-sidebarbg="skin5">
          <!-- Sidebar scroll-->
          <div class="scroll-sidebar">
              <!-- Sidebar navigation-->
              <nav class="sidebar-nav">
                  <ul id="sidebarnav" class="pt-4">   
                      <li class="sidebar-item">
                          <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('home') }}"
                              aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span
                                  class="hide-menu">หน้าหลัก</span></a>
                      </li>
                      <li class="sidebar-item">
                          <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ url('/listsale') }}"
                              aria-expanded="false"><i class="fa-solid fa-shop"></i><span
                                  class="hide-menu">ขายสินค้า</span></a>
                      </li>
                      <li class="sidebar-item">
                          <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                              aria-expanded="false"><i class="mdi mdi-receipt"></i><span class="hide-menu">สินค้า
                              </span></a>
                          <ul aria-expanded="false" class="collapse first-level">
                              <li class="sidebar-item">
                                  <a href="{{ url('/products') }}" class="sidebar-link"><i
                                          class="mdi mdi-note-outline"></i><span class="hide-menu"> รายการสินค้า
                                      </span></a>
                              </li>

                              <li class="sidebar-item">
                                  <a href="{{ route('inventory.index') }}" class="sidebar-link"><i
                                          class="mdi mdi-note-plus"></i><span class="hide-menu"> จัดการสต๊อกสินค้า
                                      </span></a>
                              </li>
                              <li class="sidebar-item">
                                  <a href="{{ route('categorys.index') }}" class="sidebar-link"><i
                                          class="mdi mdi-note-plus"></i><span class="hide-menu"> หมวดหมู่ </span></a>
                              </li>
                              <li class="sidebar-item">
                                  <a href="{{ route('subcategory.index') }}" class="sidebar-link"><i
                                          class="mdi mdi-note-plus"></i><span class="hide-menu"> ประเภท </span></a>
                              </li>
                              <li class="sidebar-item">
                                  <a href="{{ route('feature.index') }}" class="sidebar-link"><i
                                          class="mdi mdi-note-plus"></i><span class="hide-menu"> คุณสมบัติ </span></a>
                              </li>
                          </ul>
                      </li>
                      @if (Auth::user()->is_admin)
                          <!-- <li class="sidebar-item">
                              <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                  aria-expanded="false"><i class="mdi mdi-face"></i><span class="hide-menu">พนักงาน
                                  </span></a>
                              <ul aria-expanded="false" class="collapse first-level">
                                  <li class="sidebar-item">
                                      <a href="{{ route('users.index') }}" class="sidebar-link"><i
                                              class="mdi mdi-emoticon"></i><span class="hide-menu"> รายชื่อพนักงาน
                                          </span></a>
                                  </li>
                                  <li class="sidebar-item">
                                      <a href="{{ route('department.index') }}" class="sidebar-link"><i
                                              class="mdi mdi-emoticon-cool"></i><span class="hide-menu"> ตำแหน่ง
                                          </span></a>
                                  </li> -->
                              <!-- </ul>
                          </li> -->
                          <li class="sidebar-item">
                              <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                  aria-expanded="false"><i class="mdi mdi-move-resize-variant"></i><span
                                      class="hide-menu">รายการขาย </span></a>
                              <ul aria-expanded="false" class="collapse first-level">
                                  <li class="sidebar-item">
                                      <a href="{{ url('historysale') }}" class="sidebar-link"><i
                                              class="mdi mdi-view-dashboard"></i><span class="hide-menu"> ประวัติการซื้อ
                                          </span></a>
                                  </li>
                                  <li class="sidebar-item">
                                      <a href="{{ url('historyProduct') }}" class="sidebar-link"><i
                                              class="mdi mdi-multiplication-box"></i><span class="hide-menu">
                                              ยอดการขายสินค้า </span></a>
                                  </li>
                                  <li class="sidebar-item">
                                      <a href="{{ url('historySaleMonth') }}" class="sidebar-link"><i
                                              class="mdi mdi-calendar-check"></i><span class="hide-menu"> ยอดขายรายเดือน
                                          </span></a>
                                  </li>
                                  <li class="sidebar-item">
                                      <a href="{{ url('historySaleYear') }}" class="sidebar-link"><i
                                              class="mdi mdi-bulletin-board"></i><span class="hide-menu"> ยอดขายรายปี
                                          </span></a>
                                  </li>
                              </ul>
                          </li>
                      @endif
                  </ul>
              </nav>
              <!-- End Sidebar navigation -->
          </div>
          <!-- End Sidebar scroll-->
      </aside>
      <!-- ============================================================== -->
      <!-- End Left Sidebar - style you can find in sidebar.scss  -->
      <!-- ============================================================== -->
