//
//  TicketDetailModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 22/03/23.
//

import Foundation
// MARK: Ticket Detail Module
struct TicketDetailModel: Codable {
    var statusCode: Int?
    var success: Bool?
    var message: String?
    var data: [QRDetails]?
}

// MARK: - QRDetails--
struct QRDetails: Codable {
    var id, orderID: Int?
    var ticketNo: String?
    var isChecked: Int?
    var createdAt, updatedAt: String?
    var orderData: OrderData?

    enum CodingKeys: String, CodingKey {
        case id
        case orderID = "order_id"
        case ticketNo = "ticket_no"
        case isChecked = "is_checked"
        case createdAt = "created_at"
        case updatedAt = "updated_at"
        case orderData = "order_data"
    }
}

// MARK: - OrderData
struct OrderData: Codable {
    var id: Int?
    var orderDetails: String?

    enum CodingKeys: String, CodingKey {
        case id
        case orderDetails = "order_details"
    }
}
